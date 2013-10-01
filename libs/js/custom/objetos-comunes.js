var gridCheck = {

	masterCheckToggle:function(idGrid){
		var masterCheck = document.getElementById(idGrid+'_masterCheck');
		var numChecks = masterCheck.attributes["g:total"].value;
		var val = masterCheck.checked;

		for(var i = 1 ; i <= numChecks ; i++ ){
			if(document.getElementById(idGrid+'_row_'+i)){
				document.getElementById(idGrid+'_row_'+i).checked = val;
			}
		}

	},

	getSelectionJSON:function(idGrid){
		var masterCheck = document.getElementById(idGrid+'_masterCheck');
		var numChecks = masterCheck.attributes["g:total"].value;
		
		var ids = "";
		for(var i = 1 ; i <= numChecks ; i++ ){
			var nomRow = idGrid+'_row_'+i;
			if(document.getElementById(nomRow)){
				if(document.getElementById(nomRow).checked){
					ids += (ids!=""?",":"")+('"'+document.getElementById(nomRow).attributes["g:id"].value+'"');
				}
			}
		}
		return (ids!='')?"["+ids+"]":false;
	},

	getSelected:function(idGrid){
		var masterCheck = document.getElementById(idGrid+'_masterCheck');
		var numChecks = masterCheck.attributes["g:total"].value;
		
		var idR = 0;
		var total = 0;
		for(var i = 1 ; i <= numChecks ; i++ ){
			var nomRow = idGrid+'_row_'+i;
			if(document.getElementById(nomRow)){
				if(document.getElementById(nomRow).checked){
					idR = document.getElementById(nomRow).attributes["g:id"].value;
					total++;
				}
			}
		}
		return {total:total,id:idR};
	}

}



var main = {
	gO:function(id){ return document.getElementById(id); }
}