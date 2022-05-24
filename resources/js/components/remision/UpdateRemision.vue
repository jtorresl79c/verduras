<template>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div v-show="invoice_state" class="card">
      <div class="header">
        <h2 class="pull-left">Crear Remision</h2>

        <h2 class="pull-right">
          <a
            href
            @click.prevent="showInvoice"
            class="btn bg-red btn-circle waves-effect waves-circle waves-float"
          >
            <i class="material-icons">X</i>
          </a>
        </h2>
      </div>

      <div class="body">
        <form @submit.prevent="store()">
          <div class="row">
            <div class="col-md-4">
              <!-- <p>Customer</p> -->
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">person</i>
                </span>
                <div class="form-line">
                  <select class="form-control" v-model="invoice.drivers_id">
                    <option value="">Lista de Responsables</option>

                    <option
                      v-for="driver in drivers"
                      :value="driver.id"
                      :key="driver.id"
                    >
                      {{ driver.drivers_name }}
                    </option>
                  </select>
                  <span
                    class="requiredField"
                    v-if="errors.hasOwnProperty('customer_id')"
                  >
                    {{
                      errors.hasOwnProperty("customer_id")
                        ? errors.customer_id[0]
                        : ""
                    }}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-2">
              <label>LOTE</label>
              <div class="input-group">
                <div class="form-line">
                  <input
                    class="form-control"
                    type="text"
                    disabled
                    name
                    v-model="invoice.lote_no"
                  />
                </div>
              </div>
            </div>

            <div class="col-md-3">
              <label>REMISION</label>
              <input
                type="number"
                name
                class="form-control"
                v-model="invoice.remision_no"
              />
              <span
                class="requiredField"
                v-if="errors.hasOwnProperty('remision_no')"
                >{{
                  errors.hasOwnProperty("remision_no")
                    ? errors.remision_no[0]
                    : ""
                }}</span
              >
            </div>

            <div class="col-md-3">
              <label>CONTENEDOR</label>
              <input
                type="text"
                name
                class="form-control"
                v-model="invoice.contenedor"
              />
              <span
                class="requiredField"
                v-if="errors.hasOwnProperty('contenedor')"
                >{{
                  errors.hasOwnProperty("contenedor")
                    ? errors.contenedor[0]
                    : ""
                }}</span
              >
            </div>

            <div class="col-md-4">
              <label>PRODUCTO</label>
              <input
                type="text"
                class="form-control"
                v-model="invoice.producto"
              />
              <span
                class="requiredField"
                v-if="errors.hasOwnProperty('producto')"
                >{{
                  errors.hasOwnProperty("producto") ? errors.producto[0] : ""
                }}</span
              >
            </div>

            <div class="col-md-3">
              <label>KGS</label>
              <input
                type="number"
                name
                class="form-control"
                v-model="invoice.kgs"
              />
              <span class="requiredField" v-if="errors.hasOwnProperty('kgs')">{{
                errors.hasOwnProperty("kgs") ? errors.kgs[0] : ""
              }}</span>
            </div>

            <div class="col-md-4">
              <label>CAJAS</label>
              <input
                type="text"
                name
                class="form-control"
                v-model="invoice.cajas"
              />
              <span
                class="requiredField"
                v-if="errors.hasOwnProperty('cajas')"
                >{{
                  errors.hasOwnProperty("cajas") ? errors.cajas[0] : ""
                }}</span
              >
            </div>

            <div class="col-md-5">
              <label>RECIBIO</label>
              <input
                type="text"
                name
                class="form-control"
                v-model="invoice.recibio"
              />
              <span
                class="requiredField"
                v-if="errors.hasOwnProperty('recibio')"
                >{{
                  errors.hasOwnProperty("recibio") ? errors.recibio[0] : ""
                }}</span
              >
            </div>

            <div class="col-md-4">
              <p>FECHA ENV.</p>
              <div class="input-group">
                <div class="form-line">
                  <vuejs-datepicker
                    :input-class="'form-control'"
                    :format="'yyyy-MM-dd'"
                    value-format="yyyy-MM-dd"
                    v-model="invoice.envio_date"
                  ></vuejs-datepicker>
                  <span
                    class="requiredField"
                    v-if="errors.hasOwnProperty('envio_date')"
                    >{{
                      errors.hasOwnProperty("envio_date")
                        ? errors.envio_date[0]
                        : ""
                    }}</span
                  >
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <p>FECHA RECIB.</p>
              <div class="input-group">
                <div class="form-line">
                  <vuejs-datepicker
                    :input-class="'form-control'"
                    :format="'yyyy-MM-dd'"
                    value-format="yyyy-MM-dd"
                    v-model="invoice.recibio_date"
                  ></vuejs-datepicker>
                  <span
                    class="requiredField"
                    v-if="errors.hasOwnProperty('recibio_date')"
                    >{{
                      errors.hasOwnProperty("recibio_date")
                        ? errors.recibio_date[0]
                        : ""
                    }}</span
                  >
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <p>FECHA DES.</p>
              <div class="input-group">
                <div class="form-line">
                  <vuejs-datepicker
                    :input-class="'form-control'"
                    :format="'yyyy-MM-dd'"
                    value-format="yyyy-MM-dd"
                    v-model="invoice.descarga_date"
                  ></vuejs-datepicker>
                  <span
                    class="requiredField"
                    v-if="errors.hasOwnProperty('descarga_date')"
                    >{{
                      errors.hasOwnProperty("descarga_date")
                        ? errors.descarga_date[0]
                        : ""
                    }}</span
                  >
                </div>
              </div>
            </div>
          </div>

          <!-- main invoice part  -->
          <div class="row">
            <div class="table-responsive">
              <table
                class="table table-bordered table-condensed"
                style="margin-bottom:10%;'"
              >
                <thead class="bg-teal">
                  <tr>
                    <th>#</th>
                    <th>Peso Bruto</th>
                    <th>Cajas</th>
                    <th>Tara</th>
                    <th>KG PROM</th>
                    <th>Peso Neto</th>
                  </tr>
                </thead>

                <tbody>
                  <tr v-for="(vl, index) in invoice.remision" :key="vl.id">
                    <td>
                      <a
                        href
                        @click.prevent="removeItem(index)"
                        style="color: red"
                      >
                        <i class="material-icons">delete</i>
                      </a>
                    </td>

                    <td>
                      <input
                        class="form-control"
                        type="text"
                        name
                        v-model="invoice.remision[index].peso_bruto"
                        placeholder="peso bruto"
                        @input="calcularTarima(index)"
                      />
                      <span
                        v-if="errors['remision.' + index + '.peso_bruto']"
                        class="requiredField"
                        >{{
                          errors["remision." + index + ".peso_bruto"][0]
                        }}</span
                      >
                    </td>

                    <td>
                      <input
                        class="form-control"
                        type="text"
                        name
                        v-model="invoice.remision[index].cajas"
                        placeholder="cajas"
                        @input="calcularTarima(index)"
                      />
                      <span
                        v-if="errors['remision.' + index + '.cajas']"
                        class="requiredField"
                        >{{ errors["remision." + index + ".cajas"][0] }}</span
                      >
                    </td>

                    <td>
                      <input
                        class="form-control"
                        type="text"
                        name
                        v-model="invoice.remision[index].tara"
                        placeholder="tara"
                        @input="calcularTarima(index)"
                      />
                      <span
                        v-if="errors['remision.' + index + '.tara']"
                        class="requiredField"
                        >{{ errors["remision." + index + ".tara"][0] }}</span
                      >
                    </td>

                    <td>
                      <input
                        class="form-control"
                        type="text"
                        name
                        v-model="invoice.remision[index].kg_prom"
                        placeholder="kg prom"
                        disabled
                      />
                      <span
                        v-if="errors['remision.' + index + '.kg_prom']"
                        class="requiredField"
                        >{{ errors["remision." + index + ".kg_prom"][0] }}</span
                      >
                    </td>
                    <!-- for getting discount amount  -->
                    <input type="hidden" />
                    <td>
                      <input
                        class="form-control"
                        type="text"
                        name
                        v-model="invoice.remision[index].peso_neto"
                        placeholder="peso neto"
                        disabled
                      />
                      <span
                        v-if="errors['remision.' + index + '.peso_neto']"
                        class="requiredField"
                        >{{
                          errors["remision." + index + ".peso_neto"][0]
                        }}</span
                      >
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="row" style="margin-top: 20px">
              <div class="col-md-12">
                <a href @click.prevent="addmore" class="btn bg-teal"
                  >+ Agregar mas</a
                >
              </div>
            </div>
          </div>

          <!-- main invoice part  -->
          <div class="row">
            <div class="col-md-8"></div>

            <div class="col-md-4" style="text-align: right">
              <div class="form-group">
                <button type="submit" class="btn bg-teal">Actualizar</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>


<script>
import { EventBus } from "../../vue-asset";
import mixin from "../../mixin";
import Datepicker from "vuejs-datepicker";
export default {
  props: ["drivers"],
  mixins: [mixin],

  components: {
    "vuejs-datepicker": Datepicker,
  },

  data() {
    return {
      invoice: {
        lote_no: "",
        customer_type: "",
        drivers_id: "",
        driver_name: "",
        driver_email: "",
        driver_phone: "",
        driver_address: "",
        remision_no: 0,
        contenedor: "",
        producto: "",
        kgs: "",
        cajas: "",
        recibio: "",
        envio_date: "",
        recibio_date: "",
        descarga_date: "",

        remision: [
          {
            peso_bruto: 0,
            cajas: 0,
            tara: 0,
            kg_prom: 0,
            peso_neto: 0,
          },
        ],
      },
      invoice_state: false,
      errors: {},
    };
  },

  created() {
    var _this = this;
    EventBus.$on("edit-remision", function (id) {
      _this.editData(id);
      _this.invoice_state = true;
      window.scrollTo(0, 0);
    });
  },

  methods: {
    // finding the data which have to be edit
    editData(id) {
      axios.get(base_url + "remision/" + id + "/edit").then((response) => {
        this.invoice = response.data;
      });
    },
    // submit update data

    store() {
      axios
        .post(
          base_url + "remision/update/" + parseInt(this.invoice.lote_no),
          this.invoice
        )
        .then((response) => {
          this.successALert(response.data);
          this.resetForm();
          this.invoice_state = false;
          EventBus.$emit("invoice-created", 1);
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;

            Swal("Oops", "please fill the form by correct data!", "error");
          } else {
            this.successAlert(error);
          }
        });
    },

    showInvoice() {
      this.invoice_state = !this.invoice_state;
      // $("html, body").animate({ scrollTop: 0 }, 800);

      axios.get(base_url + "get/remision/number").then((response) => {
        this.invoice.lote_no = response.data;
      });

      window.scrollTo(0, top);
    },

    addmore() {
      this.invoice.remision.push({
        peso_bruto: 0,
        cajas: 0,
        tara: 0,
        kg_prom: 0,
        peso_neto: 0,
      });
    },

    removeItem(index) {
      var _this = this;
      if (_this.invoice.remision.length > 1) {
        _this.invoice.remision.splice(index, 1);
        // _this.totalPrice(index);
      }
    },

    resetForm() {
      this.invoice = {
        lote_no: "",
        customer_type: "",
        drivers_id: "",
        driver_name: "",
        driver_email: "",
        driver_phone: "",
        driver_address: "",
        remision_no: 0,
        contenedor: "",
        producto: "",
        kgs: "",
        cajas: "",
        recibio: "",
        envio_date: "",
        recibio_date: "",
        descarga_date: "",

        remision: [
          {
            peso_bruto: 0,
            cajas: 0,
            tara: 0,
            kg_prom: 0,
            peso_neto: 0,
          },
        ],
      };
    },



    calcularTarima(index){
      let remision = this.invoice.remision[index];
      let pesoBruto = remision.peso_bruto
      let cajas = remision.cajas
      let tara = remision.tara

      // Los tres valores deben de ser diferentes de 0 para que se haga un calculo
      if( !(pesoBruto && cajas && tara) ) return null;





      let pesoVerdurasYPlasticoTotal = pesoBruto - 17;

      let pesoVerduraYPlasticoIndividual = pesoVerdurasYPlasticoTotal / cajas;

      let pesoSoloVerdurasSinCaja = pesoVerduraYPlasticoIndividual - tara;

      remision.kg_prom = pesoSoloVerdurasSinCaja.toFixed(2);
      remision.peso_neto = (pesoSoloVerdurasSinCaja*cajas).toFixed(2);

    }
  },

  // end of method section

  computed: {
    /* totalAmount(){
      let sum = 0;
      this.invoice.product.forEach(function(item) {
        sum += item.total_price;
      });

      return sum;


    },

    totalDiscount(){
      let sum = 0;
      this.invoice.product.forEach(function(item){
        sum = +sum + +item.discount_amount;
      });

      return sum;
    }
 */
  },
};
</script>

<style type="text/css">
.requiredField {
  color: red;
}
</style>