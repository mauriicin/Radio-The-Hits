<?php 
/**
 * Classe para criação de formulários nos módulos
 */
class Form {
	/**
	 * Opções do formulário
	 * @var array
	 *
	 * Opções disponíveis:
	 * [horizontal]			=> true / false - se o formulário é horizontal ou não
	 * [all_inputs_filled]	=> true / false - se todos os inputs devem ser preenchidos
	 * [form_action]		=> string 		- ação ao enviar
	 * [form_method]		=> GET / POST 	- metódo de envio
	 * [form_name]			=> string 		- nome do formulário
	 * [form_submit]		=> true / false - se o input[submit] desativa ao enviar
	 * [form_return]		=> string 		- retorno do formulário
	 * [form_classes]		=> string 		- classes do formulário
	 */
	
	private $options_available = array(
		"horizontal",
		"all_inputs_filled",
		"form_action",
		"form_method",
		"form_name",
		"form_submit",
		"form_return",
		"form_classes"
		);
	
	private $options_padrao = array(
		"horizontal" => false,
		"all_inputs_filled" => false,
		// Vai ser declarado no __construct: "form_action" => $_SERVER['REQUEST_URI'], (http://stackoverflow.com/questions/6982037/php-class-server-variable-a-property)
		"form_method" => "POST",
		"form_name" => "form",
		"form_submit" => true,
		"form_return" => '',
		"form_classes" => '',
		);

	/**
	 * Configurações definitivas do formulário
	 * @var array
	 */
	private $options = array();

	/**
	 * Dados do formulário
	 * @var string
	 */
	private $form_open_tag;
	private $form_fields;

	public $form;

	/**
	 * Construtor - Setar as configurações do formulário
	 * @param array $options configurações do formulário
	 */
	public function __construct($options_given) {
		$this->options_padrao['form_action'] = $_SERVER['REQUEST_URI']; // http://stackoverflow.com/questions/6982037/php-class-server-variable-a-property

		// Para cada opção disponível, verifique se foi dado valor ou se deve obter do padrão
		// O valor (padrão ou dado) está em $valor
		foreach ($this->options_padrao as $key => $atual) {
			(($options_given[$key] == '')) ? $valor = $this->options_padrao[$key] : $valor = $options_given[$key];
			$this->options[$key] = $valor;
		}

		$classes = '';

		if($this->options['all_inputs_filled']) { $classes .= 'form-full '; }
		if($this->options['horizontal']) { $classes .= 'form-horizontal '; }
		if($this->options['form_submit']) { $classes .= 'form-submit '; }

		$this->options['form_classes'] .= substr($classes, 0, -1);

		$this->createFormTag();
	}

	/**
	 * Criar a tag de abertura do formulário
	 * @return string tag de abertura do formulário
	 */
	public function createFormTag() {
		$form_tag = '<form action="'.$this->options['form_action'].'" method="'.$this->options['form_method'].'" class="'.$this->options['form_classes'].'" enctype="multipart/form-data">';
		$form_tag .= '<div class="form-return">'.$this->options['form_return'].'</div>';
		$form_tag .= '<input type="hidden" name="'.$this->options['form_name'].'" value="'.$this->options['form_name'].'">';

		$this->form_open_tag = $form_tag;
	}

	/**
	 * Criar um input
	 * @param  string  $label       nome do campo
	 * @param  string  $tipo        tipo do input
	 * @param  string  $nome        nome do input
	 * @param  string  $classes     classes do form-group
	 * @param  string  $placeholder placeholder do input
	 * @param  string  $value       valor pré-definido do input
	 * @param  boolean $disabled    se está desabilitado ou não (true ou false)
	 * @return string               label + input prontos
	 */
	public function createInput($label, $tipo, $nome, $classes = '', $placeholder = '', $value = '', $disabled = false) {
		(($classes != '')) ? $classes = ' ' . $classes : '';
		(($disabled)) ? $disabled = ' disabled="disabled"' : '';

		$label = '<label for="input-'.$nome.'" class="form-label">' . $label . '</label>';
		$input = '<input type="'.$tipo.'" id="input-'.$nome.'" name="'.$nome.'" class="form-input" placeholder="'.$placeholder.'" value="'.$value.'"'.$disabled.'>';

		$this->form_fields .= '<div class="form-group'.$classes.'">' . $label . $input . '</div>';
	}

	/**
	 * Gerar o formulário com todas as opções e campos
	 * @return string formulário completo + submit + tag de fechamento
	 */
	public function generateForm() {
		$form_complete = $this->form_open_tag . $this->form_fields;
		$form_complete .= '<button type="submit" class="btn btn-info btn-submit">Enviar</button>';
		$form_complet .= '</form>';

		$this->form .= $form_complete;
		return $this->form;
	}
}