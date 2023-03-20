
function openTrelloComments(url){		
	var $docurl = document.location.href;		
	
myWindow = window.open(url,'popUpWindow','height=800,width=800,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no, status=yes');	
	myWindow.focus();		
	
}