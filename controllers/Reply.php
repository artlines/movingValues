<?

include_once($_SERVER['DOCUMENT_ROOT'].'/exceptions/exceptions.php');

class Reply
{
	private $db;
	private $data = [];

	function __construct($db)
	{
		$this->db = $db;

		if (!empty($_POST['data'])){
			try {
				$this->getData($_POST['data']);
			} catch (CommonException $e) {
				echo $e->getMessage();
			}
		}else{
			$client_type = $this->db->getClientType();
			$data['types'] = $client_type;
			$this->render('main', $data);
		}
	}

	//Получение отчетa
	private function getData(string $form_data)
	{
		$data = $this->dataPrepare($form_data);
		$result = $this->db->getReply($data);

		if (is_array($result)) {
			$this->render('result', $result);
		}else{
			throw new CommonException('Не могу получить данные!'.var_dump($result));
		}
	}

	//Подготовка данных
	private function dataPrepare(string $str): array
	{
		parse_str($str, $data);
		return $data;
  }

	//Подключение шаблонов
	private function render($template, $data)
	{
    include_once($_SERVER['DOCUMENT_ROOT'].'/view/'.$template.'.php');
  }


}