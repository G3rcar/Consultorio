var mainAgenda = {

	docSeleccionado:0,

	cargarAgenda:function(idDoctor){
		var _t = this;
		_t.docSeleccionado = idDoctor;
		_t.crearEvento(1,'h_5_d_1','Juan P&eacute;rez','Doc. Cerna');
		_t.crearEvento(2,'h_3_d_1','Manuel Salazar','Doc. Cerna');
		_t.crearEvento(3,'h_3_d_2','Carlos Perla','Doc. Cerna');
		_t.crearEvento(4,'h_4_d_3','Oscar Funes','Doc. Cerna');
		_t.crearEvento(5,'h_6_d_5','Sara Rodezno','Doc. Cerna');
	},

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

