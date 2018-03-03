$(document).ready(function() {
    
//Selecting check boxes    
$('#selectAllBoxes').click(function(event){
    
    if(this.checked){
      
      $('.checkBoxes').each(function(){
         this.checked = true; 
      });
      
  }else{
      
      $('.checkBoxes').each(function(){
         this.checked = false; 
      });
      
  }
    
    });
    
    
//This is adding a loading screen to the pages 
var div_box = "<div id='load-screen'><div class='loader'></div></div>";    

$("body").prepend(div_box);
    
$('#load-screen').delay(400).fadeOut(600,function(){
 $(this).remove();                             
});

   
function loadUsersOnline(){
//
$.get("/new_website/cms_2/admin/functions.php?onlineusers=result", function(data){
    
 $(".usersonline").text(data);
    
});
    
};
    

//This function executes within every half a second   
setInterval(function(){
   
    loadUsersOnline(); 
    
},500); //Half a second
  
});