<template>
    <!-- Crear proyecto en el welcome-->
        <section class="signup-section" id="Addproject">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-lg-8 mx-auto text-center">
                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#agregarProyecto">
                          Publica tu Proyecto
                        </button>
                        <!--Modal agregar proyecto-->
                        <div class="modal fade" id="agregarProyecto" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Agregar nuevo proyecto</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form @submit.prevent="agregar">
                                    <input type="text" placeholder="Nombre" class="form-control mb-2" v-model="nota.nombre" required>
                                    <div class="form-row">
                                      <div class="form-group col-md-6">
                                        <label>Tipo de Proyecto</label>
                                          <select class="custom-select form-control mb-2" v-model="nota.tipo">
                                          <option>Seleciona tipo</option>
                                          <option :value="item.nombre" v-for="(item, index) in tipos" :key="index" v-text="item.nombre"></option>
                                        </select>
                                      </div>
                                      <div class="form-group col-md-6">
                                        <label>Servicio</label>
                                          <select class="custom-select form-control mb-2" v-model="nota.servicio">
                                            <option>Seleciona tu servicio</option>
                                            <option :value="item.nombre" v-for="(item, index) in servicios" :key="index" v-text="item.nombre"></option>
                                          </select>
                                      </div>
                                    </div>
                                    <textarea type="textarea" placeholder="Descripcion" class="form-control mb-2" v-model="nota.descripcion" required></textarea>
                                    <input type="hidden" value="Sin Aceptar" class="form-control mb-2" v-model="nota.estatus">
                                    <input type="email" placeholder="Correo" class="form-control mb-2" v-model="nota.correo" required>
                                    <input type="cel" placeholder="Teléfono" class="form-control mb-2" v-model="nota.telefono" required>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button class="btn btn-primary" type="submit">Agregar</button>
                                    </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--/Modal agregar proyecto-->
                    </div>
                </div>
            </div>
        </section>
</template>

<script>
export default {
  data() {
    return {
      notas: [],
      nota: {nombre: '',
            tipo: '',
            servicio: '',
            descripcion: '',
            estatus: 'Sin Aceptar',
            correo: '',
            telefono: ''},
      tipos: [],
      tipo: {nombre: ''},
      servicios: [],
      servicio: {nombre: ''}
    }
  },
  created(){
    axios.get('/proyectot').then(res=>{
      this.tipos = res.data;
    })
    axios.get('/proyectos').then(res=>{
      this.servicios = res.data;
    })
  },
  methods:{
    agregar(){
      const notaNueva = this.nota;
     this.nota = {nombre: '', tipo: '', servicio: '', descripcion: '', estatus: '',correo: '', telefono: ''};    
      axios.post('/proyecto', notaNueva)
        .then((res) =>{
          const notaServidor = res.data;
          this.notas.push(notaServidor);
        })
      Swal.fire({
      icon: 'success',
      title: 'Proyecto Agregado',
      footer: 'Nos comunicaremos contigo',
      timerProgressBar: true,
      showConfirmButton: false,
      timer: 2500
    })
    $('#agregarProyecto').modal('hide')
    }
  }
}
</script>