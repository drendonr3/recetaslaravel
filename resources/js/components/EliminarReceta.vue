<template>
    <input 
    value="Eliminar X" 
    type="submit" 
    class="btn btn-danger mb-2 w-100 d-block"
    @click='eliminarReceta'
    >
</template>

<script>
    export default {
        props:['recetaId'],
       // mounted(){
         //   console.log('receta actual', this.recetaId)
       // },
        methods:{
            eliminarReceta(){
                this.$swal({
                    title: '¿Deseas eliminar Esta Receta?',
                    text: "Una Vez Eliminada No Se Puede Recuperar",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const params = {
                            id:this.recetaId
                        }
                        axios.post(`/recetas/${this.recetaId}`,{params,_method:'delete'})
                        .then((respuesta)=>{
                            console.log(respuesta);
                                this.$swal({
                                title:'Receta eliminada',
                                text:'Se eliminó la receta',
                                icon:'success'
                            });

                            // Eliminar receta del DOM
                            const elementEliminar = this.$el.parentNode.parentNode;
                            elementEliminar.parentNode.removeChild(elementEliminar);
                        })
                        .catch((error)=>{
                            console.log(error);
                        });
                    }
                })
            }
        }
    }
</script>
