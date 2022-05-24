<template>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <h2 v-if="!invoice_state">
      <button @click="showInvoice" type="button" class="btn btn-primary">
        <i class="glyphicon glyphicon-plus"></i> Nueva Remision
      </button>
    </h2>
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
                  <select class="form-control" v-model="invoice.customer_type">
                    <option value>Seleccionar Responsable</option>
                    <option :value="1">Desde la base de datos</option>
                    <option :value="2">Nuevo Responsable</option>
                  </select>
                  <span
                    class="requiredField"
                    v-if="errors.hasOwnProperty('customer_type')"
                    >{{
                      errors.hasOwnProperty("customer_type")
                        ? errors.customer_type[0]
                        : ""
                    }}</span
                  >
                </div>
              </div>
            </div>

            <div class="col-md-4" v-if="invoice.customer_type == 1">
              <!-- <p>Customer</p> -->
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">person</i>
                </span>
                <div class="form-line">
                  <multiselect
                    v-model="invoice.drivers_id"
                    deselect-label=""
                    track-by="id"
                    label="drivers_name"
                    open-direction="bottom"
                    placeholder="Seleccione responsable"
                    :options="drivers"
                    :allow-empty="false"
                  >
                  </multiselect>
                  <span
                    class="requiredField"
                    v-if="errors.hasOwnProperty('drivers_id')"
                    >{{
                      errors.hasOwnProperty("drivers_id")
                        ? errors.drivers_id[0]
                        : ""
                    }}</span
                  >
                </div>
              </div>
            </div>
          </div>

          <div class="row" v-if="invoice.customer_type == 2">
            <div class="col-md-6">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">person</i>
                </span>
                <div class="form-line">
                  <input
                    type="text"
                    name
                    class="form-control"
                    placeholder="Nombre de responsable"
                    v-model="invoice.driver_name"
                  />
                  <span
                    class="requiredField"
                    v-if="errors.hasOwnProperty('driver_name')"
                    >{{
                      errors.hasOwnProperty("driver_name")
                        ? errors.driver_name[0]
                        : ""
                    }}</span
                  >
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">email</i>
                </span>
                <div class="form-line">
                  <input
                    type="text"
                    name
                    class="form-control"
                    placeholder="Correo de responsable"
                    v-model="invoice.driver_email"
                  />
                  <span
                    class="requiredField"
                    v-if="errors.hasOwnProperty('driver_email')"
                    >{{
                      errors.hasOwnProperty("driver_email")
                        ? errors.driver_email[0]
                        : ""
                    }}</span
                  >
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">phone</i>
                </span>
                <div class="form-line">
                  <input
                    type="text"
                    name
                    class="form-control"
                    placeholder="Numero telefonico:"
                    v-model="invoice.driver_phone"
                  />
                  <span
                    class="requiredField"
                    v-if="errors.hasOwnProperty('driver_phone')"
                    >{{
                      errors.hasOwnProperty("driver_phone")
                        ? errors.driver_phone[0]
                        : ""
                    }}</span
                  >
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="material-icons">note</i>
                </span>
                <div class="form-line">
                  <textarea
                    rows="1"
                    class="form-control no-resize auto-growth"
                    placeholder="Direccion de responsable"
                    v-model="invoice.driver_address"
                  ></textarea>
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
                        value
                        disabled
                      />
                      <!-- {{invoice.remision[index].}} -->
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
                <button type="submit" class="btn bg-teal">Generar</button>
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
import Multiselect from "vue-multiselect";
export default {
  props: ["drivers"],
  mixins: [mixin],

  components: {
    "vuejs-datepicker": Datepicker,
    Multiselect,
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

  methods: {
    store() {
      axios
        .post(base_url + "remision", this.invoice)
        .then((response) => {
          this.successALert(response.data);
          this.resetForm();
          this.invoice_state = false;
          EventBus.$emit("invoice-created", 1);
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;

            Swal(
              "Oops",
              "por favor complete el formulario con los datos correctos!",
              "error"
            );
          } else {
            this.successAlert(error);
          }
        });
    },

    showInvoice() {
      this.invoice_state = !this.invoice_state;
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
};
</script>
