    	<a href="#!" onclick="javascript:cerrarsong()" style="color:#000; text-decoration:none; font-family:Arial, Helvetica, sans-serif; font-size:12px">
        	<div style="position:absolute; top: 5px; left: 750px; width:50px; padding:2px; background:#CCC; text-align:center">Cerrar</div>
         </a>
       <?php
		$title = $_POST['title'];
		$title = str_replace(" ", "+", $title);
 		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,"http://goodfidelity.com/artistas.php?buscarcancion=".$title."");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_MAXREDIRS,10);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,100);
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
		curl_setopt($ch,CURLOPT_HTTP_VERSION,'CURLOPT_HTTP_VERSION_1_1');
		$data = curl_exec($ch);	
		$error = curl_error($ch);
		curl_close($ch);
		preg_match_all("(<span id=\"IDvideo\" style=\"display:none\">(.*)</span>)siU", $data, $matches1);
		preg_match_all("(<span id=\"TITLEvideo\">(.*)</span>)siU", $data, $matches2);
		preg_match_all("(<span id=\"DESvideo\">(.*)</span>)siU", $data, $matches3);
		?>
       
		<?php
		for ( $X = 0 ; $X <= 49 ; $X ++) {
			$IDvideo=$matches1[1][$X];
			$IMAGEvideo= "http://i.ytimg.com/vi/".$IDvideo."/2.jpg";
			$TITLEvideo= utf8_decode($matches2[1][$X]);
			$DESvideo= utf8_decode($matches3[1][$X]);
			?>
            <a href="http://youtube.com/embed/<?php echo $IDvideo; ?>?autoplay=1&autohide=0&showinf1=0&modestbranding=1&iv_load_policy=3" target="reprotube">
            <div style="float:left; margin-left:10px; margin-bottom:10px;">
                <div style="float:left; width:120px; margin:0 5px 5px 5px; height: 90px">
                	<img src="<?php echo $IMAGEvideo ?>" width="120" height="90" /> 
                </div>
                	<?php echo $TITLEvideo ?><br />
                    <span style="color:#444"><?php echo $DESvideo ?></span>
            </div>
            </a>
            <?php
		}?>
