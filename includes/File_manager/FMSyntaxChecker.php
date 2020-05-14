<?php
// Security check 
defined('ABSPATH') || exit;

if(!class_exists('FMSyntaxChecker')):

class FMSyntaxChecker{

	public function checkSyntax($cmd, &$args, $elfinder, $volume){
		$args['content'] = stripcslashes($args['content']);
		if(strpos($args, '<?php') !== false){
			$tempFilePath = __DIR__ . DIRECTORY_SEPARATOR . 'temp.php';
			$fp = fopen($tempFilePath, "w+");
			fwrite($fp, $args['content']);
			fclose($fp);
			exec("php -l " . $tempFilePath , $output, $return);
			if(strpos($output[0], 'Errors parsing' ) !== false) {
				$errorMessage = __("Syntax Error found. Please check your code for syntax error.",'njt-file-manager');
			}
			unlink($tempFilePath);
			if($return !== 0) {
				return array(
					'preventexec' => true,
					'results' => array(
						'error' => array($errorMessage),
					),
				);
			}
		}
		return true;
	}
}
endif;