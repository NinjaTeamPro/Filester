<?php

defined('ABSPATH') || exit;

if(!class_exists('FMMimeTypes')):

class FMMimeTypes{

	public function getArrMimeTypes(){
		$arrMimeTypes = array (
			//text
			'txt' => 'text/plain',
			'htm' => 'text/html',
			'html' => 'text/html',
			'php' => 'text/html',
			'css' => 'text/css',
			'js' => 'application/javascript',
			'json' => 'application/json',
			'xml' => 'application/xml',

			// images
			'png' => 'image/png',
			'jpe' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpg' => 'image/jpeg',
			'gif' => 'image/gif',
			'bmp' => 'image/bmp',
			'ico' => 'image/vnd.microsoft.icon',
			'tiff' => 'image/tiff',
			'tif' => 'image/tiff',
			'svg' => 'image/svg+xml',
			'svgz' => 'image/svg+xml',

			// archives
			'zip' => 'application/zip',
			'rar' => 'application/x-rar-compressed',
			'exe' => 'application/x-msdownload',
			'msi' => 'application/x-msdownload',
			'cab' => 'application/vnd.ms-cab-compressed',
			'tar' => 'application/x-tar',
			'gz' => 'application/x-gzip',
			'bz2' => 'application/x-bzip2',
			'7z' => 'application/x-7z-compressed',

			// audio
			'mp3' => 'audio/mpeg',
			'mp4a' => 'audio/mp4',
			'mpega' => 'audio/mpeg',
			'mpga' => 'audio/mpeg',
			'aac' => 'audio/x-aac',
			'm3u' => 'audio/x-mpegurl',
			'mpa' => 'audio/mpeg',
			'wav' => 'audio/x-wav',
			'wma' => 'audio/x-ms-wma',

			//video
			'flv' => 'video/x-flv',
			'qt' => 'video/quicktime',
			'mov' => 'video/quicktime',
			'avi' => 'video/x-msvideo',
			'mp4v' => 'video/mp4',
			'mpegv' => 'video/mpeg',
			'mpg' => 'video/mpeg',
			'wmv' => 'video/x-ms-wmv',
			'mpav' => 'video/mpeg',
			'swf' => 'application/x-shockwave-flash',
			
			// adobe
			'pdf' => 'application/pdf',
			'psd' => 'image/vnd.adobe.photoshop',
			'ai' => 'application/postscript',
			'eps' => 'application/postscript',
			'ps' => 'application/postscript',

			// ms office
			'doc' => 'application/msword',
			'rtf' => 'application/rtf',
			'xls' => 'application/vnd.ms-excel',
			'ppt' => 'application/vnd.ms-powerpoint',
			'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
			'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
			'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
			'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
			'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
			
			// open office
			'odt' => 'application/vnd.oasis.opendocument.text',
			'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
		);
		return $arrMimeTypes;
	}
}

endif;