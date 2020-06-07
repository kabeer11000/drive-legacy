<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, ">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
</head>
<body>
<style type="text/css">
body{
  -webkit-tap-highlight-color:transparent;
  background: #FAFAFA;
}
.fileuploader{
  position: static;
  background: #FAFAFA;
  width: 100%;
  height: 10em;
}
.fileuploader #upload-label{
  background: #009688;
  color: #fff;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
  -moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
  -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
  padding: 16px;
  position: absolute;
  top: 20vh;
  left: 0;
  right: 0;
  margin-right: auto;
  margin-left: auto;
  min-width: 20%;
  text-align: center;
  padding-top: 40px;
  transition: 0.8s all;
  -webkit-transition: 0.8s all;
  -moz-transition: 0.8s all;
  cursor: pointer;
}
.fileuploader.active{
  background: #009688;
}
.fileuploader.active #upload-label{
  background: #fff;
  color: #009688;
}
.fileuploader #upload-label span.title{
  font-size: 1.1em;
  font-weight: bold;
  display: block;
}
.fileuploader #upload-label i{
  text-align: center;
  display: block;
  background: white;
  color: #009688;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
  -moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
  -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
  border-radius: 100%;
  width: 80px;
  height: 80px;
  font-size: 60px;
  padding-top: 10px;
  position: absolute;
  top: -50px;
  left: 0;
  right: 0;
  margin-right: auto;
  margin-left: auto;
}
/** Preview of collections of uploaded documents **/
.preview-container{
  position: fixed;
  right: 2.5vw;
  bottom: 0px;
  width: 95vw;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
  -moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
  -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
  visibility: hidden;
}
.preview-container #previews{
  max-height: 400px;
  overflow: auto; 
}
.preview-container #previews .zdrop-info{
  width: 88%;
  margin-right: 2%;
}
.preview-container #previews.collection{
  margin: 0;
}
.preview-container #previews.collection .actions a{
  width: 1.5em;
  height: 1.5em;
  line-height: 1;
}
.preview-container #previews.collection .actions a i{
  font-size: 1em;
  line-height: 1.6;
}
.preview-container #previews.collection .dz-error-message{
  font-size: 0.8em;
  margin-top: -12px;
  color: #F44336;
}
.preview-container .header{
  background: #009688;
  color: #fff;
  padding: 0.5em;
}
.preview-container .header i{
  float: right;
  cursor: pointer;
}
@media(min-width: 600px){
	.preview-container{
	  position: fixed;
	  right: 2.5vw;
	  bottom: 0px;
	  width: 35vw;
	  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
	  -moz-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
	  -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
	  visibility: hidden;
	}
}
</style>
<script type="text/javascript">
	$(document).ready(function(){

				initFileUploader("#zdrop");

				function initFileUploader(target) {
					var previewNode = document.querySelector("#zdrop-template");
					previewNode.id = "";
					var previewTemplate = previewNode.parentNode.innerHTML;
					previewNode.parentNode.removeChild(previewNode);


					var zdrop = new Dropzone(target, {
						url: 'single.php',
						maxFilesize:20,
						previewTemplate: previewTemplate,
						autoQueue: true,
						previewsContainer: "#previews",
						clickable: "#upload-label",
						method :"post",
                        paramName: 'file[]'
					});

					zdrop.on("addedfile", function(file) { 
						$('.preview-container').css('visibility', 'visible');
					});

					zdrop.on("totaluploadprogress", function (progress) {
						var progr = document.querySelector(".progress .determinate");
						if (progr === undefined || progr === null)
							return;

						progr.style.width = progress + "%";
					});

					zdrop.on('dragenter', function () {
						$('.fileuploader').addClass("active");
					});

					zdrop.on('dragleave', function () {
						$('.fileuploader').removeClass("active");			
					});

					zdrop.on('drop', function () {
						$('.fileuploader').removeClass("active");	
					});
					
					var toggle = true;
					/* Preview controller of hide / show */
					$('#controller').click(function() {
						if(toggle){
							$('#previews').css('visibility', 'hidden');
							$('#controller').html("keyboard_arrow_up");
							$('#previews').css('height', '0px');
							toggle = false;
						}else{
							$('#previews').css('visibility', 'visible');
							$('#controller').html("keyboard_arrow_down");
							$('#previews').css('height', 'initial');
							toggle = true;
						}
					});
					/* Close controller */
					$('#close').click(function() {
						$('.preview-container').css('visibility', 'hidden');
					});
				}

			});
</script>
  <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
	rel="stylesheet">
</head>
<body>	
	<div class="row">
		<div class="col s12">
			<!-- Uploader Dropzone -->
			<div id="zdrop" class="fileuploader ">
				<div id="upload-label" style="width: 200px;">
					<i class="material-icons">cloud_upload</i>
					<span class="title">Drag your Files here</span>
					<span>Upload to <b>My Drive</b> <span/>
				</div>
			</div>
			<!-- Preview collection of uploaded documents -->
			<div class="preview-container">
				<div class="header">
					<span>Uploaded Files</span>	
					<i id="close" class="material-icons">close</i>
					<i id="controller" class="material-icons">keyboard_arrow_down</i>
				</div>
				<div class="collection card" id="previews">
					<div class="collection-item clearhack valign-wrapper item-template" id="zdrop-template">
						<div class="left pv zdrop-info" data-dz-thumbnail>
							<div>
								<span data-dz-name></span>  <span data-dz-size></span>
							</div>
							<div class="progress">
								<div class="determinate" style="width:0" data-dz-uploadprogress></div>
							</div>
							<div class="dz-error-message"><span data-dz-errormessage></span></div>
						</div>

						<div class="secondary-content actions">
							<a href="#!" data-dz-remove class="btn-floating ph red white-text waves-effect waves-light"><i class="material-icons white-text">clear</i></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/dropzone.min.js"></script>
</body>
</html>



<hr>

<form action="single.php" enctype="multipart/form-data" method="post">
<input type="file" name="file[]" onchange="this.form.submit()">
</form>