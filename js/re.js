// JavaScript Document
function abrirsong(){
	var framesong = parent.document.getElementById("reproplay");
	framesong.style.display = "block";
}
function cerrarsong(){
	var framesong = parent.document.getElementById("reproplay");
	framesong.style.display = "none";
}
$(document).ready(function() {
    $('#form, #title').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
				$('#contenedor').html(data);
            }
        })        
        return false;
    });
});