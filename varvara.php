<?php 

/* ------------------ [ Стартовые настройки ] --------------------- */

$config = array(
	// Маска файлов
	'maskfiles'		=> array('.php', '.htm', '.html', '.tpl', '.txt', '.inc', '.js'),
	// Минимальное кол-во символов
	'minsearch'		=> 2,
	// Максимальный размер файлов
	'maxfilesize'	=> 500*1024,
	// Время ожидания работы скрипта
	'exectime'		=> 180,
);

/* ------------------ [ Настройки PHP ] --------------------- */

ini_set ( 'memory_limit', '128M' );
ini_set ( 'display_errors', '1' );
ini_set ( 'max_execution_time', $config['exectime'] );
set_time_limit($config['exectime']);
error_reporting(E_ALL);

/* ------------------ [ Параметры поиска ] --------------------- */

$params = array(
	'search_text'	=> '',
	'slowmode'		=> false,
	'fastmode'		=> false,
	'use_charset'   => false,
	'charset'		=> 'WINDOWS-1251',
	'off_cyr_fix'	=> false,
	'maskfiles'		=> $config['maskfiles'],
	'use_masks'		=> false,
	'version'		=> 'new',
	'old_search'	=> false,
	'dir'			=> __DIR__,
	'where'			=> 'file',
	'excludes'		=> array(),
);

/* ------------------ [ Сбор полученных параметров ] --------------------- */

// Текст для поиска
if ( isset($_REQUEST['text']) ) {
	$text = $_REQUEST['text'];
	$text = str_replace('\"', '"', $text);
	$text = str_replace("\'", "'", $text);
	$params['search_text'] = $text;
}

// Медленный режим
if ( isset($_REQUEST['slowmode']) ) {
	$params['slowmode'] = true;
}

// Быстрый режим
if ( isset($_REQUEST['fastmode']) ) {
	$params['fastmode'] = true;
}

// Кодировка
if ( isset($_REQUEST['use_charset']) ) {
	$params['use_charset'] = true;
}
if ( isset($_REQUEST['charset']) ) {
	$params['charset'] = $_REQUEST['charset'];
}

// Фикс поиска кириллицы
if ( isset($_REQUEST['off_cyr_fix']) ) {
	$params['off_cyr_fix'] = true;
}

// Использовать маску файлов
if ( isset($_REQUEST['mask']) ) {
	$params['use_masks'] = true;
}

// Маска расширений файлов
if ( isset($_REQUEST['masks']) ) {
	$params['maskfiles'] = explode(";", $_REQUEST['masks']);
}

// Версия поиска внутри файлов
if ( isset($_REQUEST['version']) ) {
	$params['version'] = $_REQUEST['version'];
	// Используется старый поиск
	if ( $params['version'] == 'old' ) {
		$params['old_search'] = true;
	}
}

// Стартовая директория поиска
if ( isset($_REQUEST['dir']) ) {
	$params['dir'] = $_REQUEST['dir'];
}

// Где искать
if ( isset($_REQUEST['where']) ) {
	$params['where'] = $_REQUEST['where'];
}

if ( isset($_REQUEST['excludeList']) && !empty($_REQUEST['excludeList']) ) {
	$params['excludes'] = explode("\r\n", $_REQUEST['excludeList']);
}

// Время работы скрипта
if ( isset($_REQUEST['exectime']) ) {
	$config['exectime'] = (int)$_REQUEST['exectime'];
	if ( $config['exectime'] > 300 ) {
		$config['exectime'] = 300;
	}
	ini_set ( 'max_execution_time', $config['exectime'] );
	set_time_limit($config['exectime']);
}

// Максимальный размер файла КБ
if ( isset($_REQUEST['maxfilesize']) ) {
	$config['maxfilesize'] = (int)$_REQUEST['maxfilesize']*1024;
}


// Шаг
$step = '1';
if ( isset($_REQUEST['step']) ) {
	$step = $_REQUEST['step'];
}

/* ------------------ [ Подсказки ] --------------------- */

$tips = array(
	'type_name'  => 'Поиск файлов, имена которых содержат искомую строку.',
	'type_file'  => 'Поиск файлов, внутри которых содержится искомая строка.',
	'new_search' => 'Поиск с использованием «grep», работает очень быстро, но может не находить искомую строку с кириллицей или врутри файлов с кодировкой отличной от основной на сервере.',
	'old_search' => 'Поиск без использования «grep», в некоторых ситуациях работает значительно точнее, хоть и медленнее.',
	'slowmode'   => 'Используется только в «Старой» версии поиска. При поиске не учитывается регистр, переносы строк и двойные пробелы.',
	'fastmode'   => 'Поиск положения искомой строки внутри файла не производится, значительно экономятся ресурсы и время, но результатом будет только список файлов, которые содержат нужный текст.',
	'exectime'   => 'Максимальное время работы скрипта в секундах. Данный параметр может не работать из-за особенностей настроек хостинга/сервера.',
	'maxfilesize'=> 'Поиск в файлах, размер которых больше указанного значения, производиться не будет.',
	'charset'    => 'Если требуется поиск по файлам с кодировкой отличной от основной на сервере.',
	'delete'	 => 'Удалить данный скрипт с сервера.',
	'off_cyr_fix' => 'По умолчанию включен фикс поиска кириллицы для «Новой» версии. Если наблюдаются проблемы при поиске кириллицы, то рекомендуется попробовать включить данную опцию.',
);

$themes = array(
	'dark' => 'body{background:#272822;color:#f8f5eb;font-family:sans-serif;font-size:90%}.searchPanel{border-color:#555}.form-group-title{color:#e6db74}.input-group-prepend{background:#555}.searchPanel__buttons > *,.btn{background:#555;border:1px solid #555;color:#fff}.off{color:#999}.searchResult__path{color:#e6db74;font-weight:700;font-size:110%}.searchResult{border-color:#555;background:#272822}.searchResult__list_elem{border-color:#555;background:#555}input[type="text"],select,textarea{background:#e3e5e8;border-color:#555}.searchPanel__buttons > :hover{background:#f92472!important}.searchResult__list_elem font{font-weight:700;font-size:120%;line-height:1}div#excludesPopup{background:#272822;border:1px solid #555}.excluded_elem{background:#555}',
	'light' => 'input.btn.start{background:#e2efda}span.btn.exclude{background:#fffdf0}span.btn.delete{background:#ffe5e5}.searchResult{background:#e2efda;margin-top:20px}.searchResult__list_elem{background:#fff}body{font-family:sans-serif;font-size:90%}.searchPanel{box-shadow:5px 5px 0}.searchResult{box-shadow:3px 3px 0}.searchResult__list_elem{box-shadow:2px 2px 0}.searchResults__alert{border:1px solid #000;padding:10px;width:1200px;margin:auto;box-sizing:border-box;box-shadow:5px 5px 0;background:#ffeb3b;text-align:center}.searchResults__info{border:1px solid #000;padding:5px;width:300px;margin:20px auto 0;box-sizing:border-box;box-shadow:5px 5px 0;background:#e2efda;text-align:center}',
);

/* ------------------ [ Последние приготовления ] --------------------- */

global $params, $config;
session_start();
header('Content-Type: text/html; charset=utf-8', true);

/* ------------------ [ Вывод HTML ] --------------------- */
?>

<?php if (isset($_GET['delete'])): ?>
	<?php 
		@unlink(__FILE__);
		if ( file_exists(__FILE__) ) {
			$echo = "<b>Внимание!</b> <br><b>Не удалось удалить файл!</b> <br>Пожалуйста, удалите файл самостоятельно.";
		}else{
			$echo = "Файл успешно <b>удалён</b>!";
		}
	?>
	<html>
		<head>
			<meta name="robots" content="noindex" />
		</head>
		<body>
			<!--noindex--><p><?=$echo?></p><!--/noindex-->
		</body>
	</html>
	<?php die(); ?>
<?php endif; ?>

<html>
	<head>
		<title>VVR-Searcher</title>
		<meta name="robots" content="noindex" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<style>
			form { margin-bottom: 0px; }
			.searchPanel { width: 1200px; margin: auto; padding: 10px 15px 15px; border: 1px solid #333; box-sizing: border-box; }
			.searchPanel__top input[type="submit"] { height: 30px; border: 1px solid #000; border-radius: 0px; margin-left: -1px; }
			.searchPanel__settings {}
			.row { display: -webkit-box; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; margin-right: -5px; margin-left: -5px; }
			.col { flex: 1; padding: 0px 5px; box-sizing: border-box; }
			.col-1-6 { flex: 0 0 16.666%; max-width: 16.666%; }
			.col-1-2 { flex: 0 0 50%; max-width: 50%; }
			.form-group { margin-bottom: 10px; }
			.input-group { position: relative; display: -webkit-box; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; -webkit-box-align: stretch; -ms-flex-align: stretch; align-items: stretch; width: 100%; }
			.input-group-prepend { margin-right: -1px; }
			.input-group-prepend { display: -webkit-box; display: -ms-flexbox; display: flex; align-items: center; padding: 0px 10px; background: #f0f0f0; border: 1px solid #333; }
			input[type="text"] { height: 28px; border: 1px solid #333; -webkit-box-flex: 1; -ms-flex: 1 1 auto; flex: 1 1 auto; }
			.searchPanel__top label { display: block; margin-bottom: 5px; line-height: 1.25; }
			.searchPanel__top .form-group input[type="text"] { width: 100%; }
			.btn { display: inline-block; width: 100%; font-size: 16px; display: flex; justify-content: center; text-align: center; align-items: center; height: 30px; border: 1px solid; background: #f0f0f0; box-sizing: border-box; cursor: pointer; padding: 0px 20px; }
			.settings-script { display: none; }
			.settings-script table tr td:first-child { padding-right: 10px; }
			.settings-script table tr td input[type="text"] { height: 24px; }
			.settings-script table { margin-top: 5px; }
			.settings-exclude {padding: 10px 0px 0px;display: none;}
			select { height: 24px; width: 100%; border: 1px solid #333; margin-bottom: 10px; }
			.settings-exclude textarea { width: 100%; border: 1px solid #333; resize: vertical; min-height: 80px; max-height: 300px; }
			.form-group-title { margin-top: 2px; margin-bottom: 5px; }
			.form-control { margin-bottom: 2px; }
			.searchPanel__buttons { display: flex; gap: 20px; }
			.searchPanel__buttons > * { width: auto; font-family: auto; }
			.searchResults { margin-top: 15px; }
			.searchResult { margin-top: 10px; padding: 0px; box-sizing: border-box; border: 1px solid; background: #f4f4f4; position: relative; }
			.searchResult__path { padding: 10px; font-weight: bold; }
			.searchResult__list { padding: 0px 10px; }
			.searchResult__list_elem { border: 1px solid; padding: 5px; margin-bottom: 5px; background: #e2efda; }
			.searchResult__list_elem:last-child { margin-bottom: 10px; }
			.searchResult__close { width: 30px; position: absolute; right: 0px; background: #ff000026; top: 0; bottom: 0px; cursor: pointer; text-align: center; opacity: 0; }
			.searchResult__close:hover { opacity: 1; }
			div.popup { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); border: 1px solid; background: #fff; outline: 1000px solid rgba(0,0,0,0.25); overflow: hidden; width: 1200px; max-width: 90%; z-index: 999; }
			.popup__body { overflow: auto; position: relative; height: 500px; padding: 0px 10px 10px; }
			.popup__header { padding: 5px; border-bottom: 1px solid; margin-bottom: 1px; font-weight: bold; }
			.popup__header > span { display: block; width: 26px; height: 26px; position: absolute; top: 1px; right: 1px; line-height: 26px; text-align: center; background: #f00; cursor: pointer; }
			.excluded_elem { margin: 5px 0px; padding: 5px; background: #f6f6f6; }
			.off { opacity: 0.5; color: #333; cursor: not-allowed; }
			.off * { cursor: not-allowed; pointer-events: none; }
		</style>
		<script>
			function toggleBlock(id){
				block = document.getElementById(id);
				if ( block.style.display == 'block' ){
					block.style.display = 'none';
				}else{
					block.style.display = 'block';
				}
			}
			function selectPreset(selectObject){
				presets = {
					'bitrix': [
						'/bitrix/cache',
						'/bitrix/admin'
					],
					'wp': [
						'/wp-admin'
					],
					'oc': [
						'/system/cache',
						'/vqmod/vqcache'
					]
				};
				preset = selectObject.value;
				textarea = document.getElementById('excludeList');
				if ( preset == '' ){
					textarea.value = '';
				}else{
					textarea.value = presets[preset].join('\r\n');
				}
			}
			function setSearchType(type){
				if ( type == 'name' ){
					let searchVersion = document.getElementById('searchVersion');
					let searchSettings = document.getElementById('searchSettings');
					searchSettings.classList.add('off');
					searchVersion.classList.add('off');
					/*document.querySelectorAll('#searchSettings input').forEach(element => {
						element.checked = false;
					});*/
				}else{
					searchSettings.classList.remove('off');
					searchVersion.classList.remove('off');
				}
			}
			function setSearchVersion(version){
				if ( version == 'new' ){
					document.getElementById('ckeckSlowmode').classList.add('off');
					document.getElementById('slowmode').checked = false;
					/*document.getElementById('ckeckCharset').classList.add('off');
					document.getElementById('use_charset').checked = false;*/
					document.getElementById('inputMaxSize').classList.add('off');
					document.getElementById('maxfilesize').checked = false;
					document.getElementById('cyrillicFix').classList.remove('off');
					document.getElementById('cyrillicFix').classList.remove('off');
				}else{
					document.getElementById('ckeckSlowmode').classList.remove('off');
					document.getElementById('ckeckCharset').classList.remove('off');
					document.getElementById('inputMaxSize').classList.remove('off');
					document.getElementById('cyrillicFix').classList.add('off');
					document.getElementById('off_cyr_fix').checked = false;
				}
			}
			function hideResult(elem){
				elem.parentNode.style.display='none';
			}
		</script>
	</head>
	<body>
		<!--noindex-->
		<div class="searchPanel">
			<form action="" method="get">
				<input type="hidden" name="start" value="1">
				<div class="searchPanel__top">
					<label for="text">Что будем искать?</label>
					<div class="form-group">
						<input type="text" name="text" value="<?php echo str_replace('"', '&quot;', $params['search_text']); ?>">
					</div>
				</div>
				<div class="searchPanel__settings">
					<div class="row">
						<div class="col">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">
											<input type="checkbox" name="mask" value="1" id="mask" <?= $params['use_masks'] || empty($params['search_text']) ? "checked" : "" ?>>
											<label for="mask">Маска:</label>
										</span>
									</div>
									<input type="text" name="masks" value="<?php echo implode(";", $params['maskfiles']) ?>">
								</div>
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">Путь:</span>
									</div>
									<input type="text" name="dir" value="<?php echo $params['dir'] ?>">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col col-1-6">
							<div id="searchTypes" class="form-group">
								<div class="form-group-title">Тип поиска</div>
								<div class="form-control form-radio"><input onchange="setSearchType('file')" name="where" value="file" id="where_file" type="radio" <?= $params['where'] == 'file' ? 'checked' : '' ?>><label for="where_file" title="<?= $tips['type_file'] ?>">Содержимое файлов</label></div>
								<div class="form-control form-radio"><input onchange="setSearchType('name')" name="where" value="name" id="where_name" type="radio" <?= $params['where'] == 'name' ? 'checked' : '' ?>><label for="where_name" title="<?= $tips['type_name'] ?>">Имена файлов</label></div>
							</div>
						</div>
						<div class="col col-1-6">
							<div id="searchVersion" class="form-group <?= $params['where'] == 'name' ? 'off' : '' ?>">
								<div class="form-group-title">Версия поиска</div>
								<div class="form-control form-radio"><input onchange="setSearchVersion('new')" name="version" value="new" id="new_search" type="radio" <?= $params['version'] == 'new' ? 'checked' : '' ?>><label for="new_search" title="<?= $tips['new_search'] ?>">Новый</label></div>
								<div class="form-control form-radio"><input onchange="setSearchVersion('old')" name="version" value="old" id="old_search" type="radio" <?= $params['version'] == 'old' ? 'checked' : '' ?>><label for="old_search" title="<?= $tips['old_search'] ?>">Старый</label></div>
							</div>
						</div>
						<div class="col col-1-6">
							<div id="searchSettings" class="form-group <?= $params['where'] == 'name' ? 'off' : '' ?>">
								<div class="form-group-title">Настройка поиска</div>
								<div id="ckeckSlowmode" class="form-control form-checkbox <?= $params['version'] == 'new' ? 'off' : '' ?>"><input name="slowmode" id="slowmode" type="checkbox" <?= $params['slowmode'] ? 'checked' : '' ?>><label for="slowmode" title="<?= $tips['slowmode'] ?>">Размытый поиск</label></div>
								<div id="ckeckFastmode" class="form-control form-checkbox"><input name="fastmode" id="fastmode" type="checkbox" <?= $params['fastmode'] ? 'checked' : '' ?>><label for="fastmode" title="<?= $tips['fastmode'] ?>">Быстрый поиск</label></div>
							</div>
						</div>
						<div class="col col-1-2">
							<div class="form-group">
								<span onclick="toggleBlock('settings')" class="btn script-toggle">Настройка скрипта</span>
								<div id="settings" class="settings-script">
									<table>
										<tr>
											<td title="<?= $tips['exectime'] ?>">Время работы:</td>
											<td><input type="text" name="exectime" value="<?= $config['exectime'] ?>"></td>
										</tr>
										<tr id="inputMaxSize" class="off">
											<td title="<?= $tips['maxfilesize'] ?>">Макс. размер файла (КБ)</td>
											<td><input type="text" id="maxfilesize" name="maxfilesize" value="<?= $config['maxfilesize'] / 1024 ?>"></td>
										</tr>
										<tr id="ckeckCharset" class="">
											<td title="<?= $tips['charset'] ?>"><input name="use_charset" id="use_charset" type="checkbox" <?= $params['use_charset'] ? 'checked' : '' ?>><label for="use_charset">Кодировка</label></td>
											<td><input name="charset" type="text" value="<?= $params['charset'] ?>"></td>
										</tr>
										<tr id="cyrillicFix" class="">
											<td title="<?= $tips['off_cyr_fix'] ?>"><input name="off_cyr_fix" id="off_cyr_fix" type="checkbox" <?= $params['off_cyr_fix'] ? 'checked' : '' ?>><label for="off_cyr_fix">Не использовать фикс кириллицы</label></td>
										</tr>
									</table>
								</div>
							</div>
							<div class="form-group">
								<span onclick="toggleBlock('exclude')" class="btn exclude-toggle">Исключить из поиcка файлы и директории</span>
								<div id="exclude" class="settings-exclude">
									<select onchange="selectPreset(this)">
										<option value="">Пресет не выбран</option>
										<option value="bitrix">Bitrix</option>
										<option value="wp">WordPress</option>
										<option value="oc">OpenCart</option>
									</select>
									<textarea name="excludeList" id="excludeList"><?= implode("\r\n", $params['excludes']) ?></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="searchPanel__buttons">
					<input class="btn start" type="submit" value="Начать поиск">
					<?php if ( !empty($_SESSION['excludes_count']) ): ?>
						<span class="btn exclude" onclick="toggleBlock('excludesPopup')">Список исключений [<?php echo $_SESSION['excludes_count']; ?>]</span>
					<?php endif ?>
					<span class="btn delete" onclick="window.location.href='?delete=1';" title="<?= $tips['delete'] ?>">Удалить скрипт</span>
				</div>
			</form>
		</div>
		
		<!-- Блок с результатами -->
		<div class="searchResults">

<?php

	/* ------------------ [ Основной функционал ] --------------------- */

	// есть результат
	if ( $step == "result" ) {

		if ( !$_SESSION['old_result'] ) {
			$_SESSION['time'] = round(microtime(true) - $_SESSION['time'] , 4);
			$_SESSION['old_result_data'] = microtime(true);
			$_SESSION['old_result'] = true;
		}else{
			echo '<div class="searchResults__alert">Это последний результат поиска, сохранённый в сессии, от <b>' . date('d.m.Y h:i:s', $_SESSION['old_result_data']) . '</b></div>';
		}

		echo '<div class="searchResults__info">';

		if ( !empty($_SESSION['excludes_count']) ) {
			if ( $params['old_search'] ) {
				$exclude_tip = '<p>Включен «старый поиск»! В данных директориях и файлах поиск <b>не производился</b>!</p>';
			}else{
				$exclude_tip = '<p>В данных файлах <b>найдено</b> искомое значение, но они исключены из результата.</p>';
			}
			echo 'Исключено из поиска <b>' . $_SESSION['excludes_count'] . '</b> элементов.<br>';
			echo '<div class="popup" id="excludesPopup" style="display:none;"><div class="popup__header">Список исключений <span onclick="toggleBlock(\'excludesPopup\')">x</span></div><div class="popup__body">'.$exclude_tip.$_SESSION['excludes_log'].'</div></div>';
		}
		
		echo 'Время поиска: <b>' . $_SESSION['time'] . '</b> сек.<br>';
		echo 'Найдено <b>' . $_SESSION['matches'] . '</b> результатов:';
		echo '</div>';

		echo $_SESSION['echo'];
	
		exit();
	}

	// Поиск
	if ( !empty($_REQUEST['start']) ) {

		if ( strlen($params['search_text']) >= $config['minsearch'] ) {
			echo '<div class="searchResults__loading">Подождите, идёт поиск...</div>';

			if ( $step == 1 ) {
				$_SESSION['files']		= array();
				$_SESSION['matches']	= 0;
				$_SESSION['echo']		= "";
				$_SESSION['outp']		= -1;
				$_SESSION['excludes_log'] = '';
				$_SESSION['excludes_count'] = 0;
				$_SESSION['time']	= microtime(true);
				$_SESSION['old_result'] = false;
			}

			if ( $params['where'] == "file" ) {
				if ( $step == 1 && !$params['old_search'] ) {
					if ( strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ) {
						$_SESSION['outp'] = -1;
						echo "<script>document.location.href=document.location.href+'&step=2'</script>";
						exit();
					}

					$masks = "";

					if ( $params['use_masks'] === true ) {
						foreach ( $params['maskfiles'] as $msk ) {
							if( trim($msk) != "" ) {
								$masks.=" --include=*.".str_replace(".","",$msk);
							}
						}
					}

					//$use_cyrillic = false;

					if( preg_match('/[\p{Cyrillic}]/u', $params['search_text']) && !$params['old_search'] && !$params['off_cyr_fix'] ){

						$grep_search_text = escapeshellarg( cyrillicToUnicode($params['search_text']) );
						$grep_search_text = preg_replace_callback(
							'/\\\\u([0-9a-fA-F]{4})/', 
							function($match){
								$symbol = mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
								if ( preg_match( '/[\p{Cyrillic}]/u', $symbol ) ) {
									return $symbol;
								}else{
									return $match[1];
								}
							}, 
							$grep_search_text
						);

					}else{
						$grep_search_text = escapeshellarg($params['search_text']);
					}

					//var_dump($grep_search_text);

					$comm = "grep -rlI $masks " . $grep_search_text . " " . $params['dir'] . " 2>/dev/null";

					if ( PHP_OS === 'FreeBSD' ) {
						$comm = "grep -rlI " . $grep_search_text . " " . $params['dir'] . " 2>/dev/null";
					}

					//var_dump($comm);die();

					$outp = wsoEx($comm);

					if ( !empty($params['excludes']) && !empty($outp) ) {
						foreach ( $outp as $key => $path ){
							if ( isExclude($path) ) {
								unset($outp[$key]);
							}
						}
					}

					if ( $outp != -1 && $params['fastmode'] ) {
						foreach ( $outp as $path ) {
							$_SESSION['echo'] .= '<div class="searchResult"><div class="searchResult__path">' . $path . ' [' . getFileSize($path) . ']</div></div>';
						}
						$_SESSION['matches'] = count($outp);
						echo "<script>document.location.href=document.location.href+'&step=result'</script>";
						exit();
					}

					$_SESSION['outp'] = $outp;

					echo "<script>document.location.href=document.location.href+'&step=2'</script>";
					exit();
				}

				$outp = $_SESSION['outp'];

				if ( $params['old_search'] ) {
					$outp = -1;
					if ( $step == 1 ) {
						echo "<script>document.location.href=document.location.href+'&step=2'</script>";
						exit();
					}
				}

				if ( $outp != -1 ) {
					foreach ( $outp as $addr ) {
						if ( trim($addr) != '' ) {
							search_in_file( $addr, $params['search_text'] );
						}
					}
					echo "<script>document.location.href=document.location.href.replace('step=2','step=result');</script>";
					exit();
				} else {
					if ( $step == 2 ) {
						//$_SESSION['echo'] .= '<div class="searchResults__info">«Новый» поиск недоступен, использована «старая» версия.</div>';
						$_SESSION['files'] = search_files($params['dir']);
						echo "<script>document.location.href=document.location.href.replace('step=2','step=3');</script>";
						exit();
					}
					if ( $step == 3 ) {
						if ( $params['slowmode'] ) {
							$params['search_text'] = trimpage($params['search_text']);
						}
						foreach ( $_SESSION['files'] as $addr ){
							if ( trim($addr) != '' ) {
								search_in_file( $addr, $params['search_text'] );
							}
						}
						echo "<script>document.location.href=document.location.href.replace('step=3','step=result');</script>";
						exit();
					}
				}
			}

			if ( $params['where'] == "name" ) {
				$_SESSION['files'] = search_files ( $params['dir'] );
				foreach ( $_SESSION['files'] as $addr ){
					if ( trim($addr) != '' ) {
						if ( strpos(strtolower($addr), strtolower($params['search_text'])) !== false ) {
							$_SESSION['echo'] .= '<div class="founddiv">' . $addr . '</div>';
							$_SESSION['matches'] ++;
						}
					}
				}
				echo "<script>document.location.href=document.location.href+'&step=result'</script>";
				exit();
			}
		} else {
			if ( empty($params['search_text']) ){
				echo '<div class="searchResults__panel error">Слишком короткая строка поиска!</div>';
			}
		}
	}

	/* ------------------ [ Функции ] --------------------- */

	function wsoEx($in) {
		$out = '';
		if (function_exists('exec')) {
			@exec($in,$out);
		} elseif (function_exists('passthru')) {
			ob_start();
			@passthru($in);
			$out = ob_get_clean();
			$out=explode("\n",$out);
		} elseif (function_exists('system')) {
			ob_start();
			@system($in);
			$out = ob_get_clean();
		} elseif (function_exists('shell_exec')) {
			$out = shell_exec($in);
			$out=explode("\n",$out);
		} elseif (is_resource($f = @popen($in,"r"))) {
			$out = "";
			while(!@feof($f))
				$out .= fread($f,1024);
			pclose($f);
			$out=explode("\n",$out);
		}
		else return -1;
		return $out;
	}

	function trimpage($page) {
		$page = trim ( $page );
		$page = str_replace ( "\n", "", $page );
		$page = str_replace ( "\r", "", $page );
		$npage = str_replace ( "  ", " ", $page );
		while ( $npage != $page ) {
			$page = $npage;
			$npage = str_replace ( "  ", " ", $page );
		}
		return $page;
	}

	function regexp($text) {
		$subj = str_replace ( " ", ' *', $text );
		$subj = "%" . $subj . "%siU";
		return $subj;
	}

	function search_in_file($path, $subj) {
		global $params, $config;
		$path=str_replace('//','/',$path);

		$file = file_get_contents ( $path );
		if($params['use_charset'])
			$file = changeCharset($file, $params['charset']);
		if($params['slowmode'])
		{
			$file = trimpage ( $file );
			$file=mb_convert_case($file, MB_CASE_LOWER);
			$subj=mb_convert_case($subj, MB_CASE_LOWER);
		}
		if (mb_strpos ( $file, $subj ) !== false) {

			if ( $params['fastmode'] ) {
				$_SESSION['echo'] .= '<div class="searchResult"><div class="searchResult__path">' . $path . ' [' . getFileSize($path) . ']</div></div>';
				$_SESSION['matches']++;
				return false;
			}


			$add="";
			$pl="";
			$f=fopen($path,"r");
			while($l=fgets($f))
			{
				if($params['use_charset'])
					$l = changeCharset($l, $params['charset']);
				$x = mb_strpos ( $l, $subj );
				if($x !== false)
				{
					if($x>100) $x=$x-100;
					else $x=0;
					$pl=mb_substr($pl,0,200);
					$l=mb_substr($l,$x,200);
					$l=htmlspecialchars($pl)."<br>".htmlspecialchars($l);
					$l=str_replace($subj,"<font color='red'>".$subj."</font>",$l);
					if(strlen($_SESSION['echo'])<=1048560)
						$add.='<div class="searchResult__list_elem">' . $l. '</div>';
				}
				$pl=$l;
			}
			fclose($f);
			$_SESSION['echo'].='<div class="searchResult"><div class="searchResult__close" onclick="hideResult(this)"></div><div class="searchResult__path">' . $path . ' [' . getFileSize($path) . ']</div><div class="searchResult__list">' . $add. '</div></div>';
			$_SESSION['matches'] ++;
		}
	}

	function enc_text_to_utf($text){
		$text=@iconv("WINDOWS-1251","UTF-8",$text);
		return $text;
	}

	function changeCharset($text, $charset = "WINDOWS-1251"){
		$text = @iconv($charset, "UTF-8", $text);
		return $text;
	}

	function search_files($path) {
		global $params, $config;

		$result = array();

		if ( !is_dir($path) ) {

			if ( $params['use_masks'] ) {
				$skip = true;
				
				foreach ( $params['maskfiles'] as $msk ) {
					if ( strpos(strtolower($path), strtolower($msk)) !== false ) {
						$skip = false;
					}
				}

				if( !$skip && filesize($path) <= $config['maxfilesize'] ) {
					return $path;
				}
			} else {
				if ( filesize($path) <= $config['maxfilesize'] ) {
					return $path;
				}
			}
		} else {
			$dir = dir($path);
			if ( $dir ){
				while ( false !== ($entry = $dir->read()) ){
					if ($entry != "." && $entry != ".." ){

						if ( !empty($params['excludes']) ) {
							if ( isExclude($path . '/' . $entry) ) {
								continue;
							}
						}

						$entry = search_files( $path . '/' . $entry );
						if ( is_array($entry) ){
							$result = array_merge ( $result, $entry );
						}else{
							$result[] = $entry;
						}
					}
				}
			}
		}
		return $result;
	}

	function cyrillicToUnicode($string){
		//$string_array = mb_str_split($string);
		$string_array = preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY);

		foreach ($string_array as $pos => $word) {
			if ( preg_match( '/[\p{Cyrillic}]/u', $word ) ) {
				$string_array[$pos] = "\u" . bin2hex(mb_convert_encoding($word, 'UCS-2', 'UTF-8'));
			}
		}

		return implode('', $string_array);
	}

	function isExclude($path){
		global $params, $config;
		foreach ($params['excludes'] as $exclude_rule) {
			if ( preg_match("%".$exclude_rule."%", $path) ) {
				$_SESSION['excludes_log'] .= "<p class='excluded_elem'><b>$path</b><br>исключено правилом:<br><span style='color:red'>$exclude_rule</span></p>";
				$_SESSION['excludes_count'] ++;
				return true;
			}
		}
		return false;
	}

	function getFileSize($file){
		$size = filesize($file);
		$a = array("B", "KB", "MB", "GB", "TB", "PB");
		$pos = 0;
		while ($size >= 1024) {
			$size /= 1024;
			$pos++;
		}
		return round($size,2)." ".$a[$pos];
	}

?>
		</div>
		<script>
			setSearchVersion('<?=$params['version']?>');
		</script>
		<!--/noindex-->
	</body>
</html>