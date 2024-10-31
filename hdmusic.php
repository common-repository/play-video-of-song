<?php
/*
Plugin Name: Play Video of Song
Plugin URI: http://bumbablog.com
Description: Este plugin permite tener un reproductor de audio y video en la parte lateral de tu web site el cual aparece y desaparece automaticamente sin alterar el diseño de tu sitio ni ocupar espacio. Aprovecha la API de GoodFidelity.com. 
Version: 2.01
Author: BUMBABlog
Author URI: http://bumbablog.com
License: GPL2
*/
?>
<?php
function bottom_bar_enqueue() {
	?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <?php
    wp_enqueue_script('play-js', plugins_url('js/re.js',__FILE__) );
}
add_action('wp_enqueue_scripts', 'bottom_bar_enqueue');
?>
<?php
function playsong(){
?>
	<a href="#!" onclick="javascript:abrirsong()" style="color:#FFF; text-decoration:none"><div id="buttonplay" style="z-index:9999; position:fixed; top:542px; left:0px; width:25px; height:45px; background:#222; padding-top:20px; font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold"><img src="/wp-content/plugins/play-video-of-song/repro_opt.png" /></div></a>
	<div id="reproplay" style= "z-index:9999; position:fixed; padding:5px; border: 1px solid #222; border-radius:3px 3px 3px 0px; top:220px; left:25px; width:800px; background:#eaeaea; display:none">
    	<a href="#!" onclick="javascript:cerrarsong()" style="color:#000; text-decoration:none; font-family:Arial, Helvetica, sans-serif; font-size:12px">
        	<div style="position:absolute; top: 5px; left: 750px; width:50px; padding:2px; background:#CCC; text-align:center">Cerrar</div>
         </a>
       <?php
		$title = "Rihanna";
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
        <div style="float:left; width:50%; background:#000;">
        	<iframe id="pantalla" name="reprotube" class="youtube-player" type="text/html" width="100%" height="375" src="http://goodfidelity.com/embed.php?idvideo=<?php echo $matches1[1][0] ?>&autoplay=0&autohide=0&showinfo=1&modestbranding=1&iv_load_policy=3" frameborder="0"></iframe>
        </div>
        <div style="float:left; margin-left:10px">
        	<form method="post" action="/wp-content/plugins/play-video-of-song/resultados.php" id="title" name="title" title="Buscar por canciones, artistas, géneros, álbumes y fragmentos de letras..." >
      			<input class="textobuscador" type="text" name="title"/>
        		<input class="botonbuscador" type="submit" value="Buscar"/>
      		</form>
        </div >
        <div id="contenedor" style="float:left; width:50%; height:335px; overflow-y:scroll; overflow-x:hidden; margin-top:5px;">
		<?php
		for ( $X = 0 ; $X <= 49 ; $X ++) {
			$IDvideo=$matches1[1][$X];
			$IMAGEvideo= "http://i.ytimg.com/vi/".$IDvideo."/2.jpg";
			$TITLEvideo= utf8_decode($matches2[1][$X]);
			$DESvideo= utf8_decode($matches3[1][$X]);
			?>
            <a href="http://goodfidelity.com/embed.php?idvideo=<?php echo $IDvideo; ?>&autoplay=1&autohide=0&showinf1=0&modestbranding=1&iv_load_policy=3" target="reprotube">
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
		</div>
	</div>
<?php
}
?>
<?php
add_filter('wp_footer', 'playsong');
?>