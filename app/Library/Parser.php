<?php

namespace App\Library;

use App\Models\TestQuestion;

class Parser
{
    public static $answers=['A','B','C','D'];
    
	public static function parse($file_name, $lang, $model='test', $id=0)
	{
		set_time_limit(5);
		$file = file_get_contents($file_name);
        $encode_from = 'cp1251';
        
		if(preg_match('/charset=([^"]+)">/', $file,$res)) {
			$encode_from=$res[1];
        }
        
		$file=mb_convert_encoding($file,'utf8',$encode_from);
		// $file=iconv($encode_from, 'utf8',$file);
		// $file=substr($file, strpos($file, '<body'));
		// return $file;
		$file = str_replace(["\r\n","\n"],	[' ',' '], $file);
		$file = preg_replace(
			[
				'/\x{A0}/u',
				'/^.*<body/sm',
				'/<\!--\[if.*?\[endif\]-->/sm',
				'/&nbsp;/',
				'/style=[\'][^\']*font-size:20[^\']*[\']/sm',
				'/<img[^>]*src=[\"][^\"]+?([\w\d\.]+)[\"][^>]*>/sm',
				'/<(\w+)[^>]*#formula#[^>]*>/ms',
				'/<(\w+)[^>]*>/',
				'/<(\/*)b>/',
				'/<\/p>/',
				'/<![^>]+>/',
				'/(<\/*(\w*:\w*|\w|div)>|<span>\s*<\/span>|<\/~b>\s*<~b>|<~b>\s*<\/~b>)/',
				'/<(\/*)~([^>]+)>/',
				// '/<(\/*(?:sub|sup))>/',
			],
			[
				'',
				'<html><body',
				' ',
				'',
				'#formula#',
				'<~img src="#image_dir#/$1">',
				'<~$1 class="formula">',
				'<$1>',
				'<$1~b>',
				'<~br>',
				'',
				' ',
				'<$1$2>',
				'{dee{$1}dee}',
			],
            $file);
            
		while (preg_match('/<span>([^<]+)<\/span>/sm', $file)) {
			$file=preg_replace('/<span>([^<]+)<\/span>/sm', '$1', $file);
        }
        
		while (preg_match('/<span class="formula">(\s*)<\/span>/sm', $file)) {
			$file=preg_replace('/<span class="formula">(\s*)<\/span>/sm', '$1', $file);
        }
        
		while (preg_match('/(<span class="formula">[^<]*)<\/span>(\s*)<span class="formula">([^<]*<\/span>)/sm', $file)) {
			$file=preg_replace('/(<span class="formula">[^<]*)<\/span>(\s*)<span class="formula">([^<]*<\/span>)/sm', '$1$2$3', $file);
		}
		// file_put_contents(storage_path().'/test1.html', $file);
		$file = preg_replace([
				'/(Вопрос|Question|Savol|Савол)\s*\d+\./i',
				'/(Ответ|Answer|Javob|Жавоб)\s*\w+\./i',
			'/(<span class="formula">|<b>)\s*(#dee_answer#)/','/\{dee\{(\/*(?:sub|sup))\}dee\}/sm','/\s+/sm'],
			[
				'#dee_question#',
				'#dee_answer#',
                '$2$1','<$1>',
                ' '
			], $file);
		// file_put_contents(storage_path().'/test.html', $file);
		// throw new Exception("Error Processing Request", 1);

		// return $file;
		$quests = explode('#dee_question#', $file);
		array_shift($quests);
		$time = str_replace(['.',' '], ['',''], microtime());
		$image_dir = '/uploads/'.($model == 'journal' ? 'j-images' : 'q-images').'/'.$time;
		foreach ($quests as $ind => $q) {
			if ($model == 'journal') {
				$quest = new JournalQuestion();
				$quest->journal_id = $id;
			} else {
				$quest = new TestQuestion();
			}
			
			$q = explode('#dee_answer#', str_replace('#image_dir#', $image_dir, $q));
			$quest->description=preg_replace(['/\s*<br>\s*$/', '/(^\s+|\s+$)/', '/<\/*b>/', '/<br>/'], ['', '', '', "<br>\n"], array_shift($q));
			$quest->lang = $lang;
            $quest->correct_answer = '-';
            
			foreach(self::$answers as $ind=>$name) {

				if (!isset($q[$ind])) {
					break;
                }

                $answer = $q[$ind];
                
				if (preg_match('/<\/*b>|@/', $answer)) {
					$quest->correct_answer=$name;
					$answer=preg_replace('/(<\/*b>|@)/', '', $answer);
                }
                
				$quest->$name = trim(preg_replace('/<br>\s*$/', '',$answer));
			}
			$quest->save();
		}

		return $image_dir;
	}
}