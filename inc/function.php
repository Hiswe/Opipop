<?php

	////////////////////////////////////////////
	//	DEBUG
	////////////////////////////////////////////

	function print_array($array)
    {
		echo '<pre>';
		print_r ($array);
		echo '</pre>';
	}




	////////////////////////////////////////////
	//	UTILITIES
	////////////////////////////////////////////

	function isOK(&$var)
    {
		if (isset ($var))
        {
			if (!empty ($var))
            {
				return true;
			}
		}
		return false;
	}

	function checkMail($email)
    {
		$atom = '[-a-z0-9!#$%&\'*+/=?^_`{|}~]';
		$domain = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
		return eregi("^$atom+(\\.$atom+)*@($domain?\\.)+$domain\$", $email);
	}

	function xmlFormat($text)
    {
		return str_replace (array ('&', "'", '"', '>', '<'), array ('&amp;', '&apos;', '&quot;', '&gt;', '&lt;'), $text);
	}

	function getLikeList($q)
    {
		$q = urldecode($q);

		// replace spimple quotes by double quotes
		$q = str_replace("'", '"', str_replace ('/\\', '', $q));

		// delet multiple quotes
		$q =  preg_replace('#("+)#is', '"', $q);

		// delet spaces near cotes
		$q = preg_replace('#(\s*"\s*)#is', '"', $q);

		// get out sentences (don't keep quotes)
		preg_match_all('#"(.+)"#isU', $q, $sentences);

		// delet sentences (and quotes)
		$q =  preg_replace('#(".+")#isU', ' ', $q);

		// delet multiple spaces
		$q =  preg_replace('#(\s+)#is', ' ', $q);

		// get words
		$words = explode(' ', trim ($q));

		$searched_list = '';

		if (count($sentences[1]) != 0)
        {
			$searched_list .= '%'.implode('%', $sentences[1]).'%';
		}

		if (!empty ($words[0]))
        {
			$searched_list .= '%'.implode('%', $words).'%';
		}
		return $searched_list;
	}

	function cutText($text, $max)
    {
		if (strlen($text) >= $max)
        {
			$text = substr($text, 0, $max);
			$text = substr($text, 0, strrpos ($text, " ")) . "...";
		}
		return $text;
	}

	function removeHTML($text)
    {
		$text = str_replace('</p>', ' ', $text);
		$text = preg_replace('#(<[^>]*>)#isU', '', $text);
		return $text;
	}




	////////////////////////////////////////////
	//	CLEAN UP TEXT
	////////////////////////////////////////////

	function makeGuid ($text)
    {
		$text = strtolower($text);
		// enleve tous les accents
		$text = strtr($text, "���������������������������", "aaaaaaooooooeeeeciiiiuuuuyn");
		// remplace tous ce qui n'est pas lettre ou chifre pas par un tir?
		$text = preg_replace ('([^a-z0-9\-_])', '-', $text);
		// remplace les tir� mustiples par un tir�
		$text = preg_replace ('(-+)', '-', $text);
		// efface les underscore et les tir�s en fin de chaine
		$text = preg_replace('(-*$)', '', $text);
		// efface les underscore et les tir�s eno.ok d�but de chaine
		$text = preg_replace('(^-*)', '', $text);

		return $text;
	}

	function removeSpecialChar($text)
    {
		return strtr ($text, "���������������������������", "aaaaaaooooooeeeeciiiiuuuuyn");
	}




	////////////////////////////////////////////
	//	DATES
	////////////////////////////////////////////

	function timeWarp($time)
    {
		if ($time > time())
        {
			$diff = $time - time();
		}
        else
        {
			$diff = time() - $time;
		}

		if ($diff < 60)
        {
			$unit = 'second';
			$n = $diff;
		}
        elseif ($diff < 3600)
        {
			$unit = 'minute';
			$n = round($diff / 60);
		}
        elseif ($diff < 86400)
        {
			$unit = 'hour';
			$n = round($diff / 3600);
		}
        elseif ($diff < 604800)
        {
			$unit = 'day';
			$n = round($diff / 86400);
		}
        elseif ($diff < 1814400)
        {
			$unit = 'week';
			$n = round($diff / 604800);
		}
        else
        {
			return date('d/m/Y', $time);
		}

		if ($n > 1)
        {
			$s = 's';
		}
        else
        {
			$s = '';
		}

		if ($time > time ())
        {
			return 'in ' . $n . ' ' . $unit . $s;
		}
        else
        {
			return $n . ' ' . $unit . $s . ' ago';
		}
	}




	////////////////////////////////////////////
	//	IMAGES
	////////////////////////////////////////////

    function redimage($src, $dest, $dw=false, $dh=false, $loose=false, $stamp=false)
    {
        // detect file type (could be a lot better)
        if (is_array($src))
        {
            $type_src = strtoupper(substr($src['name'], -3));
            $src = $src['tmp_name'];
        }
        else
        {
            $type_src = strtoupper(substr($src, -3));
        }

        $type_dest = strtoupper(substr($dest, -3));

        // read source image
        switch ($type_src)
        {
            case 'JPG':
            case 'PEG':
                $src_img = ImageCreateFromJpeg($src);
                break;
            case 'GIF':
                $src_img = ImageCreateFromGif($src);
                break;
            case 'PNG':
                $src_img = imageCreateFromPng($src);
                break;
            case 'BMP':
                $src_img = imageCreatefromWBmp($src);
                break;
        }

        // get it's info
        $size = GetImageSize($src);
        $sw = $size[0];
        $sh = $size[1];

        // do not redim the pic
        if ($dw == false && $dh == false)
        {
            $dest_img = ImageCreateTrueColor($sw, $sh);

            ImageCopyResampled($dest_img, $src_img, 0, 0, 0, 0, $sw, $sh, $sw, $sh);
        }
        // redim the pix with dest W as max Side
        elseif ($dw != 0 && $dh == false)
        {
            if ($sw == $sh)
            {
                $dh = $dw;
            }
            elseif ($sw > $sh)
            {
                $dh = round(($dw / $sw) * $sh);
            }
            else
            {
                $dh = $dw;
                $dw = round(($dh / $sh) * $sw);
            }

            $dest_img = ImageCreateTrueColor($dw, $dh);

            ImageCopyResampled($dest_img, $src_img, 0, 0, 0, 0, $dw, $dh, $sw, $sh);
        }
        // redim the pic according to dest W or dest H
        elseif ($dw == 0 || $dh == 0)
        {
            if ($dw == 0)
            {
                $dw = round(($dh / $sh) * $sw);
            }
            elseif ($dh == 0)
            {
                $dh = round(($dw / $sw) * $sh);
            }

            $dest_img = ImageCreateTrueColor($dw, $dh);

            ImageCopyResampled($dest_img, $src_img, 0, 0, 0, 0, $dw, $dh, $sw, $sh);
        }
        // redim the pic and crop it according to dest W and dest H
        else
        {
            $test = ($loose) ? $sw / $sh > $dw / $dh : $sw / $sh < $dw / $dh;

            if ($test)
            {
                $th = $sh;
                $tw = round($sh * ($dw / $dh));

                $x = round(($tw - $sw) / 2);
                $y = 0;
            }
            else
            {
                $tw = $sw;
                $th = round($sw * ($dh / $dw));

                $x = 0;
                $y = round(($th - $sh) / 2);
            }

            $temp_img = ImageCreateTrueColor($tw, $th);
            $dest_img = ImageCreateTrueColor($dw, $dh);

            imagefill($temp_img, 0, 0, imagecolorallocate($dest_img, 255, 255, 255));

            ImageCopyResampled($temp_img, $src_img, $x, $y, 0, 0, $sw, $sh, $sw, $sh);
            ImageCopyResampled($dest_img, $temp_img, 0, 0, 0, 0, $dw, $dh, $tw, $th);

            ImageDestroy($temp_img);
        }

        if ($stamp != false)
        {
            // detect file type (could be a lot better)
            $type_stamp = strtoupper(substr($stamp, -3));

            // read  stamp
            switch ($type_stamp)
            {
                case 'JPG':
                case 'PEG':
                    $stamp_img = ImageCreateFromJpeg($stamp);
                    break;
                case 'GIF':
                    $stamp_img = ImageCreateFromGif($stamp);
                    break;
                case 'PNG':
                    $stamp_img = imageCreateFromPng($stamp);
                    break;
                case 'BMP':
                    $stamp_img = imageCreatefromWBmp($stamp);
                    break;
            }

            // get it's info
            $size = GetImageSize($stamp);
            $stw = $size[0];
            $sth = $size[1];

            $sx = $dw - $stw;
            $sy = $dh - $sth;

            imagecolortransparent($stamp_img, imageColorAllocate($stamp_img, 0, 0, 0));

            imagecopy($dest_img, $stamp_img, $sx, $sy, 0, 0, $stw, $sth);
        }

        // free destination
        if (file_exists($dest))
        {
            unlink($dest);
        }

        // save dest image
        switch ($type_dest)
        {
            case 'JPG':
            case 'PEG':
                imageJpeg($dest_img, $dest, 100);
                break;
            case 'GIF':
                imageGif($dest_img, $dest, 100);
                break;
            case 'PNG':
                imagePng($dest_img, $dest, 100);
                break;
            case 'BMP':
                imageWBmp($dest_img, $dest, 100);
                break;
        }

        // free memory
        imageDestroy($src_img);
        ImageDestroy($dest_img);
    }

