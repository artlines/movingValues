<?php
class Db{

  private $server;
  private $user;
  private $password;
  private $base;
  private $connect;

  const PAYMENT_TYPE_RECALCULATION = 3;

  function __construct(array $config)
  {
    $this->server 	= $config['server'];
    $this->user 		= $config['user'];
    $this->password = $config['password'];
    $this->base 		= $config['base'];

    //установить соединение на основе реквизитов из конфига
    try{
      $this->makeConnect();	
    }catch(CommonException $e){
      echo $e->getMessage();
    }

  }

  private function makeConnect()
  {
    $this->connect = new mysqli($this->server, $this->user, $this->password, $this->base);

    if ($this->connect->connect_errno) {
      throw new CommonException('Не могу подключиться к базе данных: '.$mysqli->connect_error);
    }   
  }

  public function getClientType(): array
  {
    if ($query = $this->connect->query("SELECT DISTINCT type FROM client")) {
      while ($row = $query->fetch_assoc()) {
        $result[] = $row;
      }
    }

    return $result;
  }

  public function getReply(array $data): array
  {
		$result = [];
		$and = $data['client_type'] > 0 ? " AND c.type = '{$data['client_type']}' " : "";

		$this->connect->query("
			CREATE TEMPORARY TABLE begin
				SELECT SUM(summa) as balance_begin, service_id 
				FROM payment p
				LEFT JOIN client c ON(p.client_id=c.id)
				WHERE date < '{$data['date_start']}' {$and}
				GROUP BY service_id;
		");

		$this->connect->query("
			CREATE TEMPORARY TABLE end
				SELECT SUM(summa) as balance_end, service_id 
				FROM payment p
				LEFT JOIN client c ON(p.client_id=c.id)
				WHERE date <= '{$data['date_end']}' {$and}
				GROUP BY service_id;
		");

		$this->connect->query("
			CREATE TEMPORARY TABLE recalc
				SELECT SUM(summa) as recalculation, service_id 
				FROM payment p
				LEFT JOIN client c ON(p.client_id=c.id)
				WHERE date BETWEEN '{$data['date_start']}' AND '{$data['date_end']}'
				AND type_payment_id = ".self::PAYMENT_TYPE_RECALCULATION." {$and}
				GROUP BY service_id;
		");


		$query = $this->connect->query("
				SELECT p.service_id, SUM(CASE WHEN summa > 0 THEN summa ELSE 0 END) as pay_come,
				 SUM(CASE WHEN summa > 0 THEN 0 ELSE summa end) as pay_out,
				 b.balance_begin, e.balance_end, r.recalculation, s.name
				FROM payment p
				LEFT JOIN begin b ON(p.service_id=b.service_id)
				LEFT JOIN end e ON(p.service_id=e.service_id)
				LEFT JOIN recalc r ON(p.service_id=r.service_id)
				LEFT JOIN service s ON(p.service_id=s.id)
				LEFT JOIN client c ON(p.client_id=c.id)
				WHERE date BETWEEN '{$data['date_start']}' AND '{$data['date_end']}' {$and}
				GROUP BY p.service_id,b.balance_begin, e.balance_end, r.recalculation;
		");

		if (!$query) {
			printf("Errormessage: %s\n", $this->connect->error);
		}

		while ($row = $query->fetch_assoc()) {
	    $result[] = $row;
	  }

		$this->connect->query("DROP table begin");
		$this->connect->query("DROP table end");
		$this->connect->query("DROP table recalc");

		$this->connect->close();
    return $result;
  }

}