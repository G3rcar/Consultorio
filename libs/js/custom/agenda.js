var mainAgenda = {

	obtenerEvento:function(id,paciente,doctor){
		return '<table class="has-events" height="90%" width="100%"><tr><td><div id="evento_'+id+'" p:id="'+id+'" class="has-events row-fluid practice">'+
		'<span class="title">'+paciente+'</span>'+
		'<span class="lecturer">'+doctor+'</span> '+
		'<span class="buttons">'+
			'<button class="btn btn-primary btn-hover" title="Editar"><i class="icon-edit icon-white"></i></button>'+
			'<button class="btn btn-primary btn-hover" title="Cancelar"><i class="icon-remove icon-white"></i></button>'+
		'</span> '+
		'</div></td></tr></table>';
	},

	crearEvento:function(id,idObj,paciente,doctor){
		var _t = this;
		if(main.gO(idObj)){
			main.gO(idObj).innerHTML = _t.obtenerEvento(1,paciente,doctor);
		}
	}


}

