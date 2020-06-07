function preload_remover()
{
        $("#preloader").hide();
         
}
        function openFile(file){

  $.ajax({url: "index.php?file="+file, success: function(result){
    document.body.innerHTML = result;
    preload_remover();
  }});
            window.history.pushState({}, document.title, "/" + "?file="+file);
}

//DRAG SELECT SYSTEM
function xampp(e){
    var id = '';
        for(var i = 0; i<e.length;i++){
            let currentId = $(e[i]).attr('data-id');
            id += currentId+',';
            
        }
        if(id == ''){$('.list-delete-button').addClass('d-none');}else{$('.list-delete-button').removeClass('d-none');}
        if($('.list-delete-button').length == 0){
        let html = $('#navbar-search-flood').html();
        let button = '<a href="server/files-server.php?delList='+id.slice(0,-1)+'" class="mdc-icon-button text-dark search_icon_button material-icons mdc-top-app-bar__action-item--unbounded list-delete-button" aria-label="Download">delete</a>';        
        $('#navbar-search-flood').html(html+button);
        }
        else{
            $('.list-delete-button').attr('href', 'server/files-server.php?delList='+id.slice(0,-1)+'');
        }
//        console.log(id.slice(0,-1));
}
function isMobile() { return ('ontouchstart' in document.documentElement); }
if(isMobile() != true){
new DragSelect({
  selectables: document.querySelectorAll('.file-card'),
  area: document.getElementById('bmd-layout-content'),
  multiSelectKeys: ['ctrlKey', 'shiftKey', 'metaKey'],
  callback: e => xampp(e)
});    
}

$(document).ready(function () {
    
    function removeURLParameter(url, parameter) {
    //better to use l.search if you have a location/link object
    var urlparts= url.split('?');   
    if (urlparts.length>=2) {

        var prefix= encodeURIComponent(parameter)+'=';
        var pars= urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i= pars.length; i-- > 0;) {    
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
                pars.splice(i, 1);
            }
        }

        url= urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : "");
        return url;
    } else {
        return url;
    }
}

function insertParam(key, value) {
    if (history.pushState) {
        // var newurl = window.location.protocol + "//" + window.location.host + search.pathname + '?myNewUrlQuery=1';
        var currentUrl = window.location.href;
        //remove any param for the same key
        var currentUrl = removeURLParameter(currentUrl, key);

        //figure out if we need to add the param with a ? or a &
        var queryStart;
        if(currentUrl.indexOf('?') !== -1){
            queryStart = '&';
        } else {
            queryStart = '?';
        }

        var newurl = currentUrl + queryStart + key + '=' + value
        window.history.pushState({path:newurl},'',newurl);
    }
}
        $('#exampleModal').modal("show");
        /*            if($("#textArea").length){
                        alert("The element you're testing is present.");
                    }*/
        $("#exampleModal").on('hidden.bs.modal', function(){
            
        $(".fileModal").remove();
            //alert("FUCK");
            window.history.replaceState({}, document.title, "/" );
            console.log(removeURLParameter(window.location.href, 'file'));

        });

        preload_remover();
    })
// FAB + TOTAL FILES
    let fab1 = document.getElementById('fab1');
    let innerFabs = document.getElementsByClassName('inner-fabs')[0];

    fab1.addEventListener('click', function () {
        innerFabs.classList.toggle('show');
    });

    document.addEventListener('click', function (e) {
        switch (e.target.id) {
            case "fab1":
            case "fab2":
            case "fab3":
            case "fab4":
            case "fabIcon":
                break;
            default:
                innerFabs.classList.remove('show');
                break;}

    });
let TotalFiles = $(".file").length;
    $('.TotalFilesCount').html('<i class="material-icons mdc-list-item__graphic" aria-hidden="true">list</i> Total Files: '+TotalFiles);
    if (TotalFiles == 0){
        $('.filestext').hide();
    }
    let TotalFolders = $('.folder').length;
    if (TotalFolders == 0){
        $('.foldertext').hide();
    }
    if(TotalFiles+$('.folder').length == 0){
        $('.mainContainer').html('<style>.noitemContanier{margin-top:5%;transition-duration:1s}.noitemImage{width:20vw;transition-duration:1s}@media screen and (max-width: 600px) {.noitemImage{width:35vw;}.noitemContanier{margin-top:25%;}}</style><div class="col-md-12  text-center noitemContanier" style="opacity: 70%;"><img src="images/nofiles-icon.svg" class="noitemImage" style="height:auto;background-color:#FAFAFA;"><div class="h5" style="margin-bottom:-1em">Nothing Here!</div><br><small class="h6">Upload a file or add from Text Editor to upload</small></div>');
    }
    
    // CONTEXT MENU BUILDERS
    function fileContextMenuBuilder(deleteLink, viewLink, downloadLink, id, sharebox, shareVal) {
        $('#menuUl').html('<a class="dropdown-item" tabindex="-1" href="'+viewLink+'" >VIEW</a><a class="dropdown-item" tabindex="-1" href="'+downloadLink+'" download target="delIframe">DOWNLOAD</a><hr><a class="dropdown-item" href="'+deleteLink+'"> DELETE</a>');
        $('#menuUl').addClass("show");
        //<form action="server/files-server.php" target="shareIframe" method="get" class="dropdown-item"> <input type="text" hidden name="share" value="'+shareVal+'"><label> <input type="checkbox" onchange="this.form.submit()" name="ShareN" value="'+id+'" '+sharebox+'> Link Sharing </label> </div> </form>
}
function folderContextMenuBuilder(deleteLink, viewLink, downloadLink, id, sharebox) {
        $('#menuUl').html('<a class="dropdown-item" tabindex="-1" href="'+viewLink+'" >OPEN</a><a class="dropdown-item" tabindex="-1" href="'+downloadLink+'" >SHARE</a><hr><a class="dropdown-item" href="'+deleteLink+'"> DELETE</a>');
        $('#menuUl').addClass("show");
}
let files = document.getElementsByClassName('file');
let folder = document.getElementsByClassName('folder');
let recent = document.getElementsByClassName('file-card');
for(i=0;i<files.length;i++){
    files[i].addEventListener('contextmenu', function (e) {
      e.preventDefault();
    }, false);
}
for(i=0;i<folder.length;i++){
    folder[i].addEventListener('contextmenu', function (e) {
      e.preventDefault();
    }, false);
}
for(i=0;i<recent.length;i++){
    recent[i].addEventListener('contextmenu', function (e) {
      e.preventDefault();
    }, false);
}
    $(document).ready(function(){

      let $contextMenu = $('#menuUl');
      
      $('html').click(function() {
          $contextMenu.removeClass('show');
          $('#menuUl').html('');
      });
      $(window).scroll(function() {
          $contextMenu.removeClass('show');
          $('#menuUl').html('');
      });
    });
// RECENT FILE DELETE HANDLER
$(document).ready(function(){
	$('.delete').on('click', function(){
	    // console closest element with class=".product-container"
	    console.log($(this).closest('.file-card'))
	    // hide this selected element
	    $(this).closest('.file-card').hide()
	}); 
})
//HIDE CONTEXT MENU ON SCROLL
$(document).ready(function(){
  $("main").scroll(function(){
      $('#menuUl').hide();
  })
})