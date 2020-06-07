<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, ">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
//Run Auth Once Each Session 
//if (!sessionStorage.auth) {
//	auth();
//	sessionStorage.auth = "true";
//}
let user = {};
var userid = '';
function auth() {
	var USERNAME = "bugs";
	var PASSWORD = "bugs";
	$.ajax({
		type: "GET",
		url: "http://drive.hosted-kabeersnetwork.unaux.com/server/api/login.php",
		dataType: 'json',
		headers: {
			"Authorization": "Basic " + btoa(USERNAME + ":" + PASSWORD)
		},
		data: '',
		success: function (data) {
//			sessionStorage.auth = "true";
			// AUTHORIZED
			console.log(data.id);
			user = {
			    name  : data.username,
			    id : data.id,
			    is_plus : data.is_plus,
			    display_info : function (){
			        return '{"name":"'+this.name+'","id": "'+this.id+'", "is_plus" : "'+this.is_plus+'"}'
			    }
			}
			sessionStorage.setItem("user", JSON.stringify(user));
		}
	});
}
//Getting folders and files from other folders by "ID"
function renderFilesFromFolder(folderid) {
	$.getJSON("http://drive.hosted-kabeersnetwork.unaux.com/server/api/folder.php?id=" + folderid, function (data) {
	    $('.file-row').append('<div class="col-md-12"><h4>Files</h4></div>');
		for (var i = 0; i < data.Files.length; i++) {
            $('.file-row').append('<colmun class="col-md-4 mb-3"><div class="card" style="width: 100%;height:100%"><div class="card-body"> <h5 class="card-title">'+data.Files[i].name+'</h5><a href="#" class="btn btn-primary">Go somewhere</a> </div></div></colmun>');
		}
	    $('.folder-row').append('<div class="col-md-12"><h4>Folders</h4></div>');
		for (var i = 0; i < data.Folders.length; i++) {
            $('.folder-row').append('<colmun class="col-md-4 mb-3"><div class="card" style="width: 100%;height:100%"><div class="card-body"> <h5 class="card-title">'+data.Folders[i].name+'</h5><a href="#" class="btn btn-primary">Go somewhere</a> </div></div></colmun>');
		}
	});
}auth();
console.log(JSON.parse(sessionStorage.getItem("user")).id);
renderFilesFromFolder(JSON.parse(sessionStorage.getItem("user")).id);
</script>
<div class="main-container">
    <div class="container">
        <div class="row folder-row">

        </div>
        <div class="row file-row">

        </div>
    </div>
</div>
