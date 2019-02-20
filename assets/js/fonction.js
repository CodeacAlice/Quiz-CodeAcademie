$( ".tiers" ).hide();
function Adm(){
  $( ".checker" ).prop( "checked", false );
  $( ".userth" ).hide();
  $( ".checker" ).prop( "required", false );
}
function user(){
  $( ".userth" ).show();
  $( ".checker" ).prop( "required", true );
}
function andi(){
  $( ".tiers" ).show();
}
function norqth(){
  $( ".tiert" ).prop( "checked", true );
  $( ".tiers" ).hide();
}
