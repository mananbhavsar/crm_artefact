<?php include_once( APPPATH . 'views/inc/ciuis_data_table_header.php' ); ?>
<?php $appconfig = get_appconfig(); ?>
<!--box-shadow: rgba(0, 0, 0, 0.3) 20px 20px 20px;-->
<style>

 
.centered-form .panel{
    background: rgba(255, 255, 255, 0.8);
    
}
.mb50{ margin-bottom: 30px; }
.mb10{ margin-bottom: 10px; }
.ck-editor__editable {
    min-height: 200px;
}
.nav-item .nav-link{ text-align: left;}
.nav-title { margin-right: 20px; }
	.tab-content{ padding:10px 0 !important; }
	.page_input {  border: none; width: 100%; }
	
	.page_input:focus {outline:none;}
	
.wrapper {
    position:relative;
    margin:0 auto;
    overflow:hidden;
	padding:5px;
  	height:50px;
}

.list {
    position:absolute;
    left:1px;
    top:0px;
  	min-width:10000px;
  	margin-left:12px;
    margin-top:0px;
}

.list li{
	display:table-cell;
    position:relative;
    text-align:center;
    cursor:grab;
    cursor:-webkit-grab;
    vertical-align:middle;
}

.scroller {
  text-align:center;
  cursor:pointer;
  display:none;
  padding:7px;
  padding-top:11px;
  white-space:no-wrap;
  vertical-align:middle;
  background-color:#fff;
}

.scroller-right{
  float:right;
}

.scroller-left {
  float:left;
}

.nav-tabs > li{
	margin-right:0px !important;
}
.files{  border-left:1px solid #CCC; min-height: 260px }
.files_list{  margin-bottom: 10px;  border: 1px solid #ffbc00; padding:10px; font-size: 16px; }
.files_list a{ color : #ffbc00; }
</style>
<form id="notebookForm" name="notebookForm" action="<?php echo base_url('notebooks/create') ?>" method="post" enctype="multipart/form-data">
<div class="ciuis-body-content" >
  <div  class="main-content container-fluid col-xs-12 col-md-12 col-lg-12"> 
    <md-toolbar class="toolbar-white">
      <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Proposal" ng-disabled="true">
          <md-icon><i class="ico-ciuis-proposals text-muted"></i></md-icon>
        </md-button>
        <h2 flex md-truncate><?php // echo lang('createnotebook') ?>COMPLETE NOTE BOOK</h2>
        <md-switch ng-model="proposal_type" aria-label="Type" ng-cloak><strong class="text-muted"><?php echo lang('for_lead')?></strong></md-switch>
        <md-button type="button" onclick="savedata()"  class="md-icon-button" aria-label="Save" ng-cloak>
          <md-progress-circular ng-show="savingProposal == true" md-mode="indeterminate" md-diameter="20"></md-progress-circular>
          <md-tooltip ng-hide="savingProposal == true" md-direction="bottom"><?php echo lang('create') ?></md-tooltip>
          <md-icon ng-hide="savingProposal == true"><i class="ion-checkmark-circled text-success"></i></md-icon>
        </md-button>
		<md-button ng-href="<?php echo base_url('notebooks')?>" class="md-icon-button" aria-label="Save" ng-cloak>
          <md-tooltip md-direction="bottom"><?php echo lang('cancel') ?></md-tooltip>
          <md-icon><i class="ion-close-circled text-danger"></i></md-icon>
        </md-button>
      </div>
    </md-toolbar>
    <md-content class="bg-white layout-padding _md" >
	
	  
	   	 <div class="box-body">
					 
				

						<div id="notebook_list_id0" class="row centered-form" style="background:#fff;">
						<div class="col-xs-12 col-sm-8 col-md-12 ">
						 <div class="panel panel-info">
							<div class="panel-body">
							<div layout-gt-xs="row">
							  <md-input-container class="md-block" flex-gt-sm>
								<input  name="notebook" id="notebook" class="form-control" placeholder="Enter Notebook Name" required="required" value="Notebooks">
							  </md-input-container>
							</div>
							<input type="hidden" class="tab_lenght" value="2">
							<div class="scroller scroller-left"><i class="glyphicon glyphicon-chevron-left"></i></div>
							<div class="scroller scroller-right"><i class="glyphicon glyphicon-chevron-right"></i></div>
							<div class="wrapper">
								<ul class="nav nav-tabs list" id="myTab" role="tablist">
									<li class="nav-item active" id="mytab1">
										<a class="nav-link row" id="tab-1" data-toggle="tab" href="#notestab-1" role="tab" aria-controls="One" aria-selected="true">
					                    <span class=col-md-10><input type="text" name="notes_title[]" class="page_input" value="Page 1"></span> 
					                    <span class="col-md-2 close_icons" style="display: none;"><i class="fa fa-close"></i></span></a>
									</li>
									<li class="btn-li">
										<a class="btn btn-success btn-xs tab_btn"  href="javascript:void(0)"><i class="fa fa-plus"></i></a>
									</li>					            
								</ul>
							</div>
					        <div class="tab-content" id="myTabContent">
						        <div class="tab-pane active p-3" id="notestab-1" role="tabpanel" aria-labelledby="tab-1">
						               <div class="row" >
							               	<div class="col-lg-8 mb10" style="text-align: justify">
												<label>Notes</label>
												<textarea type="text" class="form-control notes_description" placeholder="Notes" name="notes_description[]" id="notes_description_1" row="5"></textarea>
											</div>
											<div class="col-lg-4 mb10 files">
												<h3>Upload FILES <a href="javascript:void(0)" class="pull-right file_upload_btn"><i class="fa fa-plus"></i></a> </h3>
												<div class="file_upload" style="display: none;">
													<input type="file" class="form-control upload_file" id="upload_file" name="upload_file[0][]" multiple="" >
												</div>
												<div class="no-item-data"></div>
											</div>
												
											
										</div>	        
						          </div>
							  </div>					
					    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
      
</md-content>
<custom-fields-vertical ng-show="!proposalsLoader && custom_fields.length > 0"></custom-fields-vertical> 
</div>

 </form>

</div>


</div>

<?php include_once( APPPATH . 'views/inc/other_footer.php' ); ?>
<script src="<?php echo base_url('assets/js/ciuis_data_table.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/estimations.js'); ?>"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/17.0.0/classic/ckeditor.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


<?php include_once( APPPATH . 'views/inc/validate_footer.php' ); ?>
<script>
   		ClassicEditor
            .create( document.querySelector( '#notes_description_1' ) )
            .catch( error => {
                console.error( error );
            } );
</script>
<script type="text/javascript">
   
$(document).on("click",".tab_btn",function(){
	var length_count = $(".tab_lenght").val();
	var tab_list= $("#mytab1").clone();
	tab_list.removeClass("active");
	tab_list.find("a .page_input").val("Page " + length_count);
	tab_list.find("a").attr("id","tab-"+length_count).attr("href","#notestab-"+length_count).attr("aria-controls",length_count);
	tab_list.find("a .close_icons").show();
	$(".btn-li").before(tab_list);

	var tab_div= $("#notestab-1").clone();
	tab_div.attr("id","notestab-"+length_count);
	tab_div.removeClass("active");
	tab_div.attr("aria-labelledby","tab-"+length_count);
	tab_div.find("input").val("").find("textarea").val("");
	tab_div.find(".ck-content p").html("&nbsp;");
	tab_div.find(".notes_title").val("Page " + length_count );
	tab_div.find(".upload_file").attr("name","upload_file["+(length_count - 1)+"][]");
	tab_div.find(".ck-editor").remove();
	tab_div.find(".notes_description").attr("id","notes_description_" + length_count);
	$("#myTabContent").append(tab_div);
	ClassicEditor
            .create( document.querySelector( '#notes_description_' + length_count) )
            .catch( error => {
                console.error( error );
            } );
	$(".tab_lenght").val(parseInt(length_count) + 1);
	
	reAdjust();
	scrollrightbar();
});


	    // $(document).on("input",".notes_title",function() {
	    // 	var dInput = this.value;
	    // 	var tab_id = $(this).parents(".tab-pane").attr('id');
	    // 	//alert(tab_id);
	    // 	$('a[href="#'+tab_id+'"] .nav-title').html(dInput);
	    // });

	    $(document).on("click",".input_Data",function(){
	    	//alert($(this).find(".fa-edit").length);
	    	if($(this).find(".fa-edit").length == 1){
		    	$(this).removeClass("btn-warning").addClass("btn-primary");
		    	$(this).find("i").removeClass("fa-edit").addClass("fa-check")
		    	$(this).parents(".input-group").find("input").removeAttr("readonly");
		    }
		    else{
		    	$(this).removeClass("btn-success").addClass("btn-warning");
		    	$(this).find("i").removeClass("fa-check").addClass("fa-edit")
		    	$(this).parents(".input-group").find("input").attr("readonly", "readonly");
		    }
	    });

	      $(document).on("click",".close_icons",function(){
	      	var isGood=confirm('Are you sure to delete?');
			    if (isGood) {
			   var href_id = $(this).parents(".nav-item").find("a").attr("href");
			       $(this).parents(".nav-item").remove();
			       $(href_id).remove();
			       $("active");
			       $("#notestab-1").addClass("active");
			    } else {
			      return false
			    }

	      });
$(document).on("click",".file_upload_btn, .close_btn",function(){
	$(this).parents(".files").find(".file_upload").toggle();
});
		  
var hidWidth;
var scrollBarWidths = 40;

var widthOfList = function(){
  var itemsWidth = 0;
  $('.list li').each(function(){
    var itemWidth = $(this).outerWidth();
    itemsWidth+=itemWidth;
  });
  return itemsWidth;
};

var widthOfHidden = function(){
  return (($('.wrapper').outerWidth())-widthOfList()-getLeftPosi())-scrollBarWidths;
};

var getLeftPosi = function(){
  return $('.list').position().left;
};

var reAdjust = function(){
  if (($('.wrapper').outerWidth()) < widthOfList()) {
    $('.scroller-right').show();
  }
  else {
    $('.scroller-right').hide();
  }
  
  if (getLeftPosi()<0) {
    $('.scroller-left').show();
  }
  else {
    $('.item').animate({left:"-="+getLeftPosi()+"px"},'slow');
  	$('.scroller-left').hide();
  }
}

reAdjust();

$(window).on('resize',function(e){  
  	reAdjust();
});

var i=1;
$('.scroller-right').click(function() { 
  $('.scroller-left').fadeIn('slow');
  //$('.scroller-right').fadeOut('slow');
  var intvalue = Math.floor(widthOfList()/325);
  var showFlag= getLeftPosi() + (i * 325);
  if(i < intvalue && widthOfList()+getLeftPosi() > 0){
	$('.list').animate({left:"-="+(showFlag)+"px"},'slow',function(){
	});
	i++;
  }
  else {
	i = 1;
	$('.scroller-right').fadeOut('slow');
  }
});

function scrollrightbar() {
	if(widthOfList() > 1300) {
		$('.scroller-left').fadeIn('slow');
		$('.scroller-right').fadeOut('slow'); 
		$('.list').animate({left:"+="+widthOfHidden()+"px"},'slow',function(){
		});
	}
}

$('.scroller-left').click(function() {
	$('.scroller-right').fadeIn('slow');
	$('.scroller-left').fadeOut('slow');
  	$('.list').animate({left:"-="+getLeftPosi()+"px"},'slow',function(){
  	
  	});
});   

function savedata(){
	$("#notebookForm").submit();
}

	</script>
	
	