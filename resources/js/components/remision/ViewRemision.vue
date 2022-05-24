<template>
  <div class="wrap">
    <!--    <div class="row">
            
            filtering element 
          </div> -->
          <div class="body">

           

                <update-remision  :drivers="drivers"></update-remision>
                <!-- <create-payment></create-payment> -->
               <!--  <view-payment></view-payment>  -->

            <!--     <div class="row">
                  <div class="col-md-4">
                    <input type="text" class="form-control "
                    v-on:keyup="getData(1)" 
                    v-model="invoice_id" 
                    placeholder="Buscar por no.factura">
                  </div>
                  <div class="col-md-4">
                    <select class="form-control  select2" data-live-serach="true"
                    @change="getData(1)" 
                    v-model="customer_id"
                    v-select="customer_id"
                    >
                    <option value="">Todos los Responsables</option>

                    <option v-for="(customer,index) in customers" :value="customer.id">{{ customer.customer_name  }}</option>
                  </select>
                </div> -->
                <div class="col-md-4">

                 <!--  <vuejs-datepicker :input-class="'form-control'" :format="'yyyy-MM-dd'" value-format="yyyy-MM-dd" :value="start_date"></vuejs-datepicker> -->


               </div>



             </div>

             <div class="loading" v-if="isLoading">
              <h2 style="text-align:center">Cargando.......</h2>
            </div>

            <div class="table-responsive" v-else>

             <table class="table table-condensed table-hover table-bordered">
               <thead>
                 <tr>
                   <th># Lote</th>
                   <th>Remision</th>
                   <th>Chofer</th>
                   <th>Producto</th>
                   <th width="20%">Acciones</th>
                 </tr>
               </thead>
               <tbody>
                 <tr v-for="(value,index) in remision.data" :key="index.id">
                   <td>{{ value.id }}</td>
                   <td>{{ value.chofer }}</td>
                   <td>{{ value.contenedor }}</td>
                   <td>{{ value.producto}}</td>
                   <td>
                    <a :href="url+'download-pdf/'+value.id" target="_blank" type="button" class="btn bg-orange btn-circle waves-effect waves-circle waves-float">
                        <i class="material-icons">print</i>
                    </a>

                    <a  @click="gotoPrint(value.id)" target="_blank" type="button" class="btn bg-red btn-circle waves-effect waves-circle waves-float">
                        <i class="material-icons">chrome_reader_mode</i>
                    </a>

                    <button @click="editInvoice(value.id)" type="button" class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                        <i class="material-icons">edit</i>
                    </button>

                    <button @click="deleteInvoice(value.id)" type="button" class="btn bg-pink btn-circle waves-effect waves-circle waves-float">
                        <i class="material-icons">delete</i>
                    </button>       
                  </td>
               </tr>
             </tbody>
           </table>
         </div>
       <!--   <pagination :pageData="invoices"></pagination> -->
       </div>
</template>

<script>


import { EventBus } from "../../vue-asset";
import mixin from "../../mixin";
import MomentMixin from '../../moment_mixin.js';
import Pagination  from '../pagination/pagination.vue';

import Datepicker from "vuejs-datepicker";
import UpdateRemision from './UpdateRemision.vue';
import Multiselect from 'vue-multiselect';

    export default {
        props: ['drivers'],
        mixins:[mixin,MomentMixin],

        components:{
            'pagination' :  Pagination,
            'update-remision' : UpdateRemision,
        },

data(){
            return {
            id: '',
            lote: '',
            cofer: '',
            contenedor: '',
            producto: '',
            invoice_id : '',
            customer_id : '',
            start_date : new Date('2019-02-03'),
            end_date : '',
            invoices : [],
            format : 'yyyy-MM-dd',
            url : base_url,
            isLoading : true,
            }
        },

        created(){
            var _this = this; 
            this.getData();

            EventBus.$on('remision-created', function () {
                _this.getData();
            });
        },

        methods : {
             getData(page = 1){

            this.isLoading = true;
            axios.get(base_url+"remision-list?page="+page).then(response =>
            {
              this.remision = response.data;
              this.isLoading = false;
            }).catch(error =>
            {
              console.log(error);
            })
          },

        gotoPrint(id) {
           let route = this.url+"get-all-remisiones/"+id 
           var w = 700;
           var h = 700;
           var left = Number((screen.width/2)-(w/2));
           var tops = Number((screen.height/2)-(h/2));
           window.open(route,"_blank", 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+tops+', left='+left); 
            
          },
           // edit vendor 

         editInvoice(id){
           EventBus.$emit('edit-remision',id);

         },
        }

       
    }
</script>