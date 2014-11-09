@extends('layaouts.buscar')
@section('titulo')
  Ascensos
@endsection
@section('head')
	<style>
		.contenedor {
			background: #fff;
			padding: 10px;
			margin-bottom: 15px;
			box-shadow: 0px 3px 2px #aab2bd;
			-moz-box-shadow: 0px 3px 2px #aab2bd;
			-webkit-box-shadow: 0px 3px 2px #aab2bd;
			left: 12px;
			border-top-width: 5px;
			border-top-style: solid;
			border-top-left-radius: .1em;
			border-top-right-radius: .1em;
		}

		.requisitos{
			background: #fff;
			border-top-width: 3px;
			border-top-style: solid;
			padding: 15px;
			box-shadow: 0px 1px 1px #aab2bd;
			-moz-box-shadow: 0px 1px 1px #aab2bd;
			-webkit-box-shadow: 0px 1px 1px #aab2bd;
			border-top-left-radius: .1em;
			border-top-right-radius: .1em;
			border-top-color: #76a7fa;
		}

		.error {
			box-shadow: 0px 0px 10px red;
			border-top-color: white;
		}

		#graficaAsistencias {
			background: #fff;
			height: 200px;
			margin-bottom: 20px;
		}

		.titulo {
			margin-top: -10px;
		}

		.listado {
			padding: 5px;
			margin-left: 0px;
		}

		.calificacion {
			font-size: 80%;
		}

		#calificaciones {
			margin-left: -14px;
			margin-right: -14px;
		}
	</style>
	{{  HTML::style('css/sweet-alert.css');  }}
	{{  HTML::script('js/jspdf.js'); }}
	{{  HTML::script('js/chart/morris.min.js'); }}
	{{  HTML::script('js/chart/raphael-min.js'); }}
@endsection
@section('elemento')
	<div class="col-md-12" style="right: 10px;">
		<div id="graficaAsistencias" class="requisitos col-md-2">
		</div>
		{{ Form::open(array('id' => 'formulariocargos','class' => 'col-md-7 contenedor','url' => 'ascensos/update','files' => true)) }}
			<div class="form-group">
				<div class="col-md-4" id="fotoperfil">
				</div>
				<div class="col-md-8">
					<div class="col-md-10">
						{{ Form::text('id', 'id',array('class' => 'hidden')) }}
						<h3 id="nombreelemento" name="nombre"></h3>
						<h4>
							{{ Form::label(null,'Matricula: ',array('class' => 'small')) }}
							{{ Form::label('matricula',null,array('class' => 'pull-right label label-default')) }}
						</h4>
						<h4>
							{{ Form::label(null,'Ubicación: ',array('class' => 'small')) }}
							{{ Form::label('companiasysubzonas',null,array('class' => 'pull-right label label-default')) }}
						</h4>
						<h4>
							{{ Form::label(null,'Grado actual: ',array('class' => 'small')) }}
							{{ Form::label('grado',null,array('class' => 'pull-right label label-danger')) }}
						</h4>
						<h4>
							{{ Form::label(null,'Desde: ',array('class' => 'small')) }}
							{{ Form::label('fechagrado',null,array('class' => 'pull-right label label-default')) }}
						</h4>
					</div>
				</div>
				{{ Form::button('<i class="fa fa-floppy-o"></i> Guardar',array('id' =>'btnupdate','class' => 'hidden pull-right btn btn-info')) }}
			</div>
		{{Form::close()}}
		<div class="calificaciones requisitos col-md-3" style="left:24px;">
			<h4 class="titulo text-center">Exámenes</h4>
			<div id="calificaciones"></div>
		</div>
	</div>
	<div class="col-md-12" style="right: 10px;">
		<div class="requisitos col-md-3">
			<h4 class="titulo text-center">Reconocimientos</h4>
			<div id="reconocimientos"></div>
		</div>
		<div class="requisitos col-md-3" style="left:12px;">
			<h4 class="titulo text-center">Pagos</h4>
			<div id="reconocimientos"></div>
		</div>
	</div>
@stop
@section('scripts2')
	{{  HTML::script('js/sweet-alert.min.js'); }}
	<script>
		function encontrado (id) {
			$('#graficaAsistencias').html('');
			$('#calificaciones').html('');
			$('#reconocimientos').html('');
			$.post('ascensos/buscar',{id:id}, function(json) {
				// console.log(json.examenesNoHechos);
				$('.fa-spinner').addClass('hidden');
				$('#elemento').removeClass('hidden');
				$('[name=id]').val(json.id);
				$('#nombreelemento').text(json.nombre+' '+json.paterno+' '+json.materno);
				$('label[for=matricula]').text(json.matricula);
				$('label[for=companiasysubzonas]').text(json.companiasysubzonas);
				$('label[for=grado]').text(json.grado);
				$('label[for=fechagrado]').text(json.fechagrado);
				if(!json.cargo){
					$('label[for=cargo]').text('Cargo: Sin cargo');
				}
				$('#fotoperfil').html('<img id="theImg" class="img-responsive img-thumbnail img-circle" src="imgs/fotos/'+json.fotoperfil+'" alt="Responsive image"/>');
				porcentajeAsistencia(json.faltas,json.permisos,json.asistencias);
				examenesVista(json.examenes,json.examenesNoHechos);
				reconocimientosVista(json.reconocimientos);
			}, 'json');
		}
		function porcentajeAsistencia (faltas,permisos,asistencias) {
			total = faltas + permisos + asistencias;
			var mo = Morris.Donut({
				element: 'graficaAsistencias',
				data: [
					{value: asistencias, label: 'Asistencias', formatted: (asistencias/total)*100+'%' },
					{value: permisos, label: 'Permisos', formatted: (permisos/total)*100+'%' },
					{value: faltas, label: 'Faltas', formatted: (faltas/total)*100+'%' },
				],
				backgroundColor: '#F7F7F7',
				labelColor: '#2B2B2B',
				colors: [
					'#4CD964',
					'#FFCC00',
					'#FF3B30',
				],
				resize: true,
				formatter: function (x, data) { return data.formatted; }
			});
			if ((asistencias/total)< .7) {
				$('#graficaAsistencias').addClass('error');
			};
		}
		function examenesVista (hechos,noHechos) {
			// console.log(hechos);
			$.each(hechos,function(index, val){
				$('#calificaciones').append('<div class="listado"><h2>'+val.nombre+'</h2><p><small>'+val.pivot.fecha+'</small><label class="pull-right label label-success calificacion">'+val.pivot.calificacion+'</label></p></div>');
				if (val.pivot.calificacion < 6) {
					$('.calificacion').addClass('label-danger');
					$('.calificacion').removeClass('label-success');
					$('.calificaciones').addClass('error');
				};
			});
			// console.log(noHechos);
			$.each(noHechos,function(index, val){
				$('#calificaciones').append('<div class="listado"><h2>'+val.nombre+'</h2><p><small>Sin fecha</small><label class="pull-right label label-danger calificacion">NO</label></p></div>');
				$('.calificaciones').addClass('error');
			});
		}
		function reconocimientosVista (data) {
			// console.log(data);
			$.each(data,function(index, val){
				$('#reconocimientos').append('<div class="listado"><h2>'+val.nombre+'</strong><p><small>'+val.fecha+'</small></p></div>');
			});
		}
	</script>
	<script>
		(function(){
			$('#btnupdate').on('click', function(e) {
				e.preventDefault();
				var str = $( "#formulariocargos" ).serialize();
				$.post('ascensos/update',$("#formulariocargos").serialize(), function(json) {
					console.log(json);
					if (!json.success) {
						swal({
								title: '¿Estás seguro?',
								text: 'Parece que '+capitalise(json.nombre)+' '+capitalise(json.paterno)+' '+capitalise(json.materno)+' tiene ese cargo en el mismo lugar.',
								type: 'warning',
								showCancelButton: true,
								confirmButtonColor: '#AEDEF4',
								confirmButtonText: 'Si',
								cancelButtonText: 'No, regresar a revisar',
								closeOnConfirm: false,
								closeOnCancel: false
							},
							function(isConfirm){
								if (isConfirm){
									swal('!Hecho!', 'Se ha guardado el cargo', 'success');
								}
								else {
									swal({
										title:'Cancelado',
										text:'No se ha guardado ningun cambio',
										type: 'error',
										timer: 1000
									});
								}
							});
					};
				}, 'json');
			});
		})();
		function capitalise(string) {
			return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
		}
	</script>
@endsection