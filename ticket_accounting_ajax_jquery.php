<?php echo $this->element("admin_header"); ?>
<?php echo $this->element("admin_topright"); ?>
<?php echo $this->element("admin_nav"); ?>
<?php echo $this->element("admin_sidebar");  ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>

<style>
.export {
float: right;
}
#total{
text-align: center;
padding: 10px;
border: 4px solid rgba(91, 0, 128, 0.63);
color: rgba(0, 128, 0, 0.81);
border-style: double;
font-size: 18px;
font-family: cursive;
}
    .event_info_wrapper{
        display: none;
    }
</style>
<div id="content">
    <div class="contentTop">
        <span class="pageTitle"><span class="icon-screen"></span>Tickets Booked</span>
        <ul class="quickStats">
            <li>
                <?php echo $this->Html->link($this->Html->Image('../images/icons/quickstats/user.png'),'javascript:void();',array('escape'=>false,'border'=>'0','class'=>'blueImg')); ?>
                <div class="floatR"><strong class="blue"><?php echo $this->Paginator->counter('{:count}');?></strong><span>Tickets</span></div>
            </li>
        </ul>
    </div>
    <!-- Breadcrumbs line -->
    <div class="breadLine">
        <div class="bc">
            <ul id="breadcrumbs" class="breadcrumbs">
                <li><a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'admin_dashboard')); ?>">Dashboard</a></li>
                <li class="current"><a href="javascript:void(0);">Tickets Booked</a></li>
            </ul>
        </div>
    </div>
    
    <!-- User type search box close -->
    <!-- Main content -->
    
    <div class="wrapper">
        <?php $x=$this->Session->flash(); ?>
        <?php if($x){ ?>
        <div class="nNote nSuccess" id="flash">
            <div class="alert alert-success" style="text-align:center" ><?php echo $x; ?></div>
        </div><?php } ?>
        <!-- Chart -->
        <div class="widget check grid6">
            <div class="whead">
                <span class="titleIcon">
                    <!--<input title="Select All" class="tool-tip" id="titleCheck" name="titleCheck" type="checkbox">--></span>    <h6 style="margin-left: -30px;">Tickets Booked</h6>
                    <!----------Revnue Filters code ------------------>
                    <div style="float: left; margin-left: 25%;margin-top: 5px;">
                        <?php echo $this->Form->create('Ticket', array('controller'=>'tickets','action'=>'index')); ?>
                        <select name="revnue_filter" onchange="this.form.submit()">
                            <option>Please select an option</option>
                            <option value="event" title="Get revenue by event">Revnue per event</option>
                            <option value="week" title="Get revenue by week">Revnue by week</option>
                            <option value="month" title="Get revenue by month">Revnue by month</option>
                        </select>
                        
                        <?php echo $this->Form->end();?>
                    </div>
                    <!---------- //Revnue Filters code ------------------>
                    <div style="float:right;">
                        <?php echo $this->Form->create('Ticket', array('controller'=>'tickets','action'=>'index')); ?>
                        <div style="margin-top:5px;">
                            <input type="text" name="keyword" title="Enter event name..."placeholder="Search the keywords" class="tipS tool-tip" autocomplete="off">
                            <input value="" type="submit" name="search">
                        </div>
                        <?php echo $this->Form->end();?>
                    </div>
                </div>
                <?php if(!empty($tickets)){ ?>
                
                <div id="dyn" class="hiddenpars" style="margin: 5px; border: 1px solid #dfdfdf;">
                    <?php  echo $this->Form->create('Ticket',array('id' => 'mbc')); ?>
                    <table cellpadding="0" cellspacing="0" class="tDefault checkAll tMedia" id="checkAll" width="100%">
                        <thead>
                            <tr>
                                <!-- <th></th>-->
                                <th style="width: 90px;"><?php echo ('Event name'); ?></th>
                                <th><?php echo('Event Date'); ?></th>
                                <th><?php echo ('Tickets Limit'); ?></th>
                                
                                <th><?php echo ('Ticket(s) Sold'); ?></th>
                                
                                
                                
                                <th><?php echo ('Venue'); ?></th>
                                <th><?php echo ('Revenue'); ?></span></th>
                                
                                
                                <!-- <th><?php //echo ('Status'); ?></th>-->
                                
                                <!--<th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody><?php $total = array(); ?>
                            <?php  foreach ($tickets as $ticket): ?>
                            <tr class="gradeX">
                                <!--<td><?php echo $this->Form->checkbox("use"+$ticket['Ticket']['id'],array('value' => $ticket['Ticket']['id'],'class'=>'checkAll')); ?></td>-->
                               
                                <td class="event_name">
                                   <input type="hidden" value="<?php echo h($ticket['Event']['id']); ?>" class="txt_val">
                                   <?php echo h($ticket['Event']['name']); ?>
                                    
                                </td>
                                <td><?php echo date("d M y",strtotime($ticket['Event']['date'])); ?></td>
                                <td><?php echo h($ticket['Event']['tickets_available']); ?></td>
                                
                                <td><?php echo h($ticket['Event']['tickets_booked']); ?></td>
                                
                                
                                <!--<td><?php if($ticket['Event']['image'] != ''){ echo $this->Html->image('/img/../files/events/'.$ticket['Event']['image'],array('height'=>'auto','width'=>'70px')); } else {
                                        echo $this->Html->image('../files/no_image.png',array('height'=>'auto','width'=>'70px'));
                                }   ?></td> -->
                                <td><?php echo h(substr($ticket['Event']['address'], 0, strrpos($ticket['Event']['address'], ","))); ?></td>
                                
                                
                                <td>
                                    <?php
                                    if(empty($revnue_filter))
                                    {
                                    echo h($ticket['Event']['ticket_price']);
                                    $total[] = h($ticket['Event']['ticket_price']);
                                    }
                                    else
                                    {
                                    echo h($ticket['Event']['ticket_price']) * h($ticket['Event']['tickets_booked']);
                                    $total[]= h($ticket['Event']['ticket_price']) * h($ticket['Event']['tickets_booked']);
                                    }
                                    
                                    ?>
                                </td>
                                
                                <!--<td><?php //if($ticket['EventBook']['status']=='1') { echo 'Activate'; } else {  echo 'Deactivate'; } ?></td>-->
                                
                                
                                <!--<td class="center">
                                <form></form>
                                <?php /* echo $this->Html->link($this->Html->image('../images/icons/admins/edit.png',array('border'=>'0','class'=>'iconb','width'=>'17')),array('action' => 'admin_edit', $ticket['EventBook']['id']),array('class'=>'tablectrl_small bDefault ','title'=>'Edit','escape'=>false)); */?>
                                
                                <?php /* echo $this->Form->postLink($this->Html->image('../images/icons/admins/delete.png',array('border'=>'0','class'=>'iconb','width'=>'17')),array('controller'=>'tickets','action'=>'delete',$ticket['EventBook']['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault ','title'=>'Delete'),__('Are you sure you want to delete %s?', $ticket['Event']['name'])); */?>
                                <?php // if ($ticket['EventBook']['status']=='0'){?>
                                <?php /*echo $this->Form->postLink($this->Html->image('../images/icons/admins/deactivate.png',array('border'=>'0','class'=>'iconb','width'=>'17')), array('action' => 'activate', $ticket['EventBook']['id']),array('escape'=>false,'class'=>'tablectrl_small bDefault ','title'=>'Activate'),__('Are you sure you want to activate #%s?', $ticket['Event']['name'])); */?><?php //}else { ?>
                                <?php/* echo $this->Form->postLink($this->Html->image('../images/icons/admins/activate.png',array('border'=>'0','class'=>'iconb','width'=>'17')), array('action' => 'block', $ticket['EventBook']['id']), array('escape'=>false,'class'=>'tablectrl_small bDefault ','title'=>'Deactivate'),__('Are you sure you want to block #%s?', $ticket['Event']['name'])); */?><?php //}?>
                            </td>-->
                        </tr>
                           
                        <?php endforeach; ?>
                    </tbody>
                </table><div class="whead">
                <h6 id="total">Total Revnue from current result: <?php  if(empty($revnue_filter))
                {
                echo array_sum($total);
                }
                else
                {
                echo h($grand_total);
                }
                ?>
                </h6>
                
            </div>



            </div>
            <br/><br/>
           
            <div class="event_info_wrapper" style="    background: rgba(0, 0, 0,.7);position: fixed;top: 0;left: 0;right: 0;bottom: 0;z-index:999;">

            <div class="event_info" style="width: 60%;height: auto;position: absolute;left: 50%;margin-left: -30%;top: 50%;margin-top: -75px;background: white;border: 2px solid #999999;transform: translateY(-25%);padding:20px" >
              
             <script>
                
                $(document).ready(function(){
                var response="";
                    
                $(".event_name").click(function(){
                  
                v=$(this).parent().find(".txt_val").val();
                 //alert(v);
                //$.cookie('text1', v);
                //var j=$.cookie('text1');
                $.ajax({
                type: "POST",
                url: '<?php echo Router::url(array('controller'=>'tickets','action'=>'admin_demo')); ?>', 
                data: ({name: v}),
                
                
                success: function(response){
             //alert(response); //will alert ok
              $("#mbc").parents().find('.event_info_wrapper').show();
              $("#mbc").parents().find('.event_info_wrapper').find('.tableId tbody').empty();
                var jdata=$.parseJSON(response);
               // alert(jdata.length); 
                for (var i=0;i<jdata.length;++i)
        {
             //alert(jdata[i].user); 
              var tr = $('<tr>').append(
                    $('<td>').text(jdata[i].user),
                    $('<td>').text(jdata[i].ticket_booked),
                    $('<td>').text(jdata[i].price),
                    
                    $('<td>').text(jdata[i].vat),
                    $('<td>').text(jdata[i].pay),
                    $('<td>').text(jdata[i].rev)

                );
              $("#mbc").parents().find('.event_info_wrapper').find('.tableId tbody').append(tr);
          


        }
            ///console.log(jdata);
           
               
                
                //console.log(tr.wrap('<p>').html());
              
             
                   }
            });
                 
               
                });

                $(".can").click(function(){
                    
               $(".event_info_wrapper").hide();
                //location.reload();
             
                });

                });
              
                 
                </script>
                <style>
                .tableId{
                    border: 1px solid #b5b2b2;
                    width: 100%;
                    text-align: center;
                }
                .tableId tr th, .tableId tr td{
                    padding: 10px;
                   
                }
                .tableId tr td{
                     border: 1px solid #b5b2b2;
                }
                </style>  
            <table class="tableId">
            <thead>
            <tr>
            <th>
            Username</th>
            <th>
            Tickets sold</th>
            <th>
            Ticket Price</th>
            <th>
            VAT</th>
            <th>Paypal Fees</th>
            <th>Revenue</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            </tr>
            </tbody>
            </table>

             



            </div>
            <div><img src="/img/cancel.png" style="width: 40px;height: 40px;margin-right: 10px;float: right;margin-top: 10px;margin-bottom:15px" class="can"></div>
            </div>
            <!-- <?php /* echo $this->Html->link('Delete All','javascript:void(0);',array('onclick'=>'return deleteAll();','class'=>'buttonS bRed','style'=>"margin-left:20px")); */?>
            <?php  /* echo $this->Html->link('Activate All','javascript:void(0);',array('onclick'=>'return activateAll();','class'=>'buttonS bGreen','style'=>"margin-left:40px")); */ ?>
            <?php /* echo $this->Html->link('Deactivate All','javascript:void(0);',array('onclick'=>'return deactiveAll();','class'=>'buttonS bBlue','style'=>"margin-left:40px")); */?>-->
            <?php  }
            else{?>
            <div id="dyn" style="text-align:center;">
                No records found.
            </div>
            <?php  }
            ?>
         
            <div class="tpages">
                <ul class="pages">
                    <li><?php echo $this->Paginator->first('First'); ?></li>
                    <li><?php if($this->Paginator->hasPrev()){ echo $this->Paginator->prev(__('Previous'), array('tag' => false)); } ?></li>
                    <li><?php echo @$this->Paginator->numbers(); ?></li>
                    <li><?php if($this->Paginator->hasNext()){ echo $this->Paginator->next(__('Next'), array('tag' => false)); } ?></li>
                    <li><?php echo $this->Paginator->last('Last'); ?></li>
                </ul>
            </div>
            
            <div style="margin-top:10px;"></div>
        </form>
    </div>
</div>
</div>
</div>
</div>
 

<script type="text/javascript">

function deleteAll() {
var anyBoxesChecked = false;
    var arr = new Array();
    var finalArr = new Array();
    
    $('#mbc input[type="checkbox"]').each(function() {
if ($(this).is(":checked")) {
            arr.push($(this).val());
            anyBoxesChecked = true;
}
});

if (anyBoxesChecked == false) {
        alert('Please select at least one checkbox to delete event.');
        return false;
} else {
    
        $.each(arr, function( index, value ) {
            var res = value.split("-");
                finalArr.push(res[0]);
        });
        if(finalArr.length > 0){
                            if(confirm("Are you sure you want to delete?")){
                $.ajax({
                    type:'POST',
                    dataType: 'json',
url:'<?php echo Router::url(array('controller'=>'tickets','action'=>'admin_deleteall')); ?>',
data: {'EventBook':finalArr},
success:function(result){
$('.checkAll').attr("checked", false);
$('#titleCheck').attr("checked", false);
window.location.reload();
}
});
return false;
}
}
return false;
}
}//end of func deleteAll//
function show(){
alert("hello");
}
function activateAll() {
var anyBoxesChecked = false;
var arr = new Array();
var finalArr = new Array();
var error = '';
$('#mbc input[type="checkbox"]').each(function() {
if ($(this).is(":checked")) {
arr.push($(this).val());
anyBoxesChecked = true;
}
});

if (anyBoxesChecked == false) {
alert('Please select at least one checkbox to activate events.');
return false;
} else {
$.each(arr, function( index, value ) {
var res = value.split("-");
if(res[1] == 1){
if(error.length > 0){
error = error+', '+res[2];
} else {
error = res[2];
}
delete arr[index];
} else {
finalArr.push(res[0]);
}
});
if(finalArr.length > 0){
if(error.length > 0){
alert('You cannot activate "'+error+'" post/s as its category status is already blocked So you have to first activate its category status.');
}
if(confirm("Are you sure you want to activate selected events?")){
$.ajax({
type:'POST',
dataType: 'json',
url:'<?php echo Router::url(array('controller'=>'tickets','action'=>'admin_activateall')); ?>',
data: {'Event':finalArr},
success:function(result){
$('.checkAll').attr("checked", false);
$('#titleCheck').attr("checked", false);
window.location.reload();
}
});
return true;
}
}
}
}//end of func activateAll//
function deactiveAll() {
var anyBoxesChecked = false;
var arr = new Array();
var finalArr = new Array();
$('#mbc input[type="checkbox"]').each(function() {
if ($(this).is(":checked")) {
arr.push($(this).val());
anyBoxesChecked = true;
}
});

if (anyBoxesChecked == false) {
alert('Please select at least one checkbox to deactivate post.');
return false;
} else {
$.each(arr, function( index, value ) {
var res = value.split("-");
finalArr.push(res[0]);
});
if(finalArr.length > 0){
if(confirm("Are you sure you want to deactivate the seleted events?")){

$.ajax({
type:'POST',
dataType: 'json',
url:'<?php echo Router::url(array('controller'=>'tickets','action'=>'admin_deactivateall')); ?>',
data: {'EventBook':finalArr},
success:function(result){
$('.checkAll').attr("checked", false);
$('#titleCheck').attr("checked", false);
window.location.reload();
}
});

return false;
}
}
return false;
}
}//end of func deactiveAll//
</script>