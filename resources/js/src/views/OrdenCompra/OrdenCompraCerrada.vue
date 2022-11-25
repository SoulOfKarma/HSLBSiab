<template>
    <div>
        <!-- Orden de Compra -->
        <vx-card title="Orden de Compra" class="md:w-1/1 w-full mb-2 mt-3">
            <div class="vx-row">
                <div
                    class="vx-col w-full mt-5"
                    v-if="listaDetalleOrdenCompra.length > 0"
                >
                    <h6>N° Interno</h6>
                    <vs-input
                        class="inputx w-full  "
                        v-model="numint"
                        disabled
                    />
                </div>
            </div>
        </vx-card>
        <vx-card title="" class="md:w-1/1 w-full mb-2 mt-3">
            <div class="vx-row">
                <div
                    class="vx-col mt-5"
                    style="padding: 0 1rem; width: 7.3% !important;"
                >
                    <h6>F. Sistema</h6>
                    <flat-pickr
                        :config="configFromdateTimePicker"
                        v-model="fechaSistema"
                        placeholder="Fecha Sistema"
                        class="w-full "
                        disabled
                    />
                </div>
                <div
                    class="vx-col mt-5"
                    style="padding: 0 0.2rem; width: 7.3% !important;"
                >
                    <h6>F. Inicio</h6>
                    <flat-pickr
                        :config="configFromdateTimePicker"
                        v-model="fechaOrdenCompra"
                        placeholder="Fecha Inicio"
                        @on-change="onFromChange"
                        class="w-full "
                        disabled
                    />
                </div>
                <div
                    class="vx-col mt-5"
                    style="padding: 0 0.2rem; width: 25.3% !important;"
                >
                    <h6>Proveedor</h6>
                    <v-select
                        v-model="seleccionProveedores"
                        placeholder="Activo"
                        class="w-full select-large"
                        label="RUTPROV"
                        :options="listadoProveedores"
                        disabled
                    ></v-select>
                </div>
                <div
                    class="vx-col mt-5"
                    style="padding: 0 0.2rem; width: 34.3% !important;"
                >
                    <h6>Nombre Proveedor</h6>
                    <vs-input
                        class="inputx w-full  "
                        v-model="descripcionProveedor"
                        disabled
                    />
                </div>
                <div
                    class="vx-col mt-5"
                    style="padding: 0 0.2rem; width: 7.3% !important;"
                >
                    <h6>Sigfe</h6>
                    <vs-input class="inputx w-full  " v-model="nsigfe" />
                </div>
                <div
                    class="vx-col mt-5"
                    style="padding: 0 0.2rem; width: 10.3% !important;"
                >
                    <h6>
                        Folio Recepcionado
                    </h6>
                    <vs-input
                        class="inputx w-full  "
                        v-model="nfoliorecepcionado"
                        disabled
                    />
                </div>
                <div
                    class="vx-col mt-5"
                    style="padding: 0 0.2rem; width: 7.3% !important;"
                >
                    <h6>
                        Año
                    </h6>
                    <vs-input class="inputx w-full  " v-model="anio" disabled />
                </div>
            </div>
        </vx-card>
        <!-- Detalles Orden Compra -->
        <div class="vx-col md:w-1/1 w-full mb-base mt-5">
            <vx-card title="">
                <div class="vx-row">
                    <vue-good-table
                        class="w-full"
                        :columns="colDetalle"
                        :rows="listaDetalleOrdenCompra"
                        :pagination-options="PageOptions"
                        styleClass="vgt-table condensed bordered"
                    >
                        <template slot="table-row" slot-scope="props">
                            <!-- Column: Name -->
                            <span
                                v-if="props.column.field === 'fullName'"
                                class="text-nowrap"
                            >
                            </span>
                            <!-- Column: Common -->
                            <span v-else>
                                {{ props.formattedRow[props.column.field] }}
                            </span>
                        </template>
                    </vue-good-table>
                </div>
            </vx-card>
            <div class="vx-row"></div>
        </div>
        <!-- Observaciones y totales -->
        <div class="vx-col md:w-1/1 w-full mb-base mt-5">
            <vx-card title="">
                <div class="vx-row">
                    <div class="vx-col w-full mt-5">
                        <h6>
                            Total
                        </h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="valorTotal"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-full mt-5">
                        <h6>Observaciones</h6>
                        <quill-editor
                            class="w-full"
                            v-model="Observaciones"
                            :options="editorOption"
                            disabled
                        >
                            <div id="toolbar" slot="toolbar"></div>
                        </quill-editor>
                    </div>
                </div>
                <br /><br />
            </vx-card>
        </div>
        <div class="vx-col md:w-1/1 w-full mb-base mt-5">
            <vx-card title="">
                <div class="vx-row">
                    <div class="vx-col w-1/2 mt-5">
                        <vs-button
                            @click="volver"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Volver</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <vs-button
                            @click="ImprimirOC"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Imprimir</vs-button
                        >
                    </div>
                </div>
            </vx-card>
        </div>
    </div>
</template>
<script>
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import router from "@/router";
import moment from "moment";
import axios from "axios";
import vSelect from "vue-select";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import "vue-good-table/dist/vue-good-table.css";
import { VueGoodTable } from "vue-good-table";
import { PlusCircleIcon } from "vue-feather-icons";
import store from "../ScriptMenus/store.js";
import Vue from "vue";
import VueTippy, { TippyComponent } from "vue-tippy";
Vue.use(VueTippy);
Vue.component("tippy", TippyComponent);

export default {
    components: {
        VueGoodTable,
        "v-select": vSelect,
        quillEditor,
        PlusCircleIcon,
        flatPickr
    },
    data() {
        return {
            //Datos Locales - Variables de Entorno
            localVal: process.env.MIX_APP_URL,
            editorOption: {
                modules: {
                    toolbar: [
                        ["bold", "italic", "underline", "strike"],
                        ["blockquote", "code-block"],
                        [{ header: 1 }, { header: 2 }],
                        [{ list: "ordered" }, { list: "bullet" }],
                        [{ indent: "-1" }, { indent: "+1" }],
                        [{ direction: "rtl" }],
                        [{ font: [] }],
                        [{ align: [] }],
                        ["clean"]
                    ]
                }
            },
            //Datos Campos
            PageOptions: store.state.PageOptions,
            popUpRecepciones: false,
            codInternoRecepcion: 0,
            descripcionServicio: "",
            nsigfe: "",
            anio: 0,
            numint: 0,
            valorTotal: 0,
            totalRecepcion: 0,
            contador: 0,
            fechaSistema: null,
            fechaOrdenCompra: null,
            nfoliorecepcionado: "",
            Observaciones: "",
            nombre: "",
            tipoDocumento: "",
            folio: 0,
            descripcionProveedor: "",
            seleccionProveedores: {
                id: 0,
                RUTPROV: "Ej. 22222222-2",
                NOMRAZSOC: ""
            },
            idMod: 0,
            //Datos Fechas
            configFromdateTimePicker: {
                minDate: null,
                maxDate: "today",
                dateFormat: "d/m/Y",
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                        longhand: [
                            "Domingo",
                            "Lunes",
                            "Martes",
                            "Miércoles",
                            "Jueves",
                            "Viernes",
                            "Sábado"
                        ]
                    },
                    months: {
                        shorthand: [
                            "Ene",
                            "Feb",
                            "Mar",
                            "Abr",
                            "May",
                            "Jun",
                            "Jul",
                            "Ago",
                            "Sep",
                            "Оct",
                            "Nov",
                            "Dic"
                        ],
                        longhand: [
                            "Enero",
                            "Febrero",
                            "Мarzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ]
                    }
                }
            },
            configTodateTimePicker: {
                minDate: null,
                dateFormat: "d/m/Y",
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                        longhand: [
                            "Domingo",
                            "Lunes",
                            "Martes",
                            "Miércoles",
                            "Jueves",
                            "Viernes",
                            "Sábado"
                        ]
                    },
                    months: {
                        shorthand: [
                            "Ene",
                            "Feb",
                            "Mar",
                            "Abr",
                            "May",
                            "Jun",
                            "Jul",
                            "Ago",
                            "Sep",
                            "Оct",
                            "Nov",
                            "Dic"
                        ],
                        longhand: [
                            "Enero",
                            "Febrero",
                            "Мarzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ]
                    }
                }
            },
            configdateTimePicker: {
                enableTime: false,
                //enableSeconds: true,
                noCalendar: true,
                time_24hr: true,
                dateFormat: "H:i"
            },
            configdateToTimePicker: {
                enableTime: false,
                noCalendar: true,
                time_24hr: true,
                dateFormat: "H:i"
            },
            //Configuracion Columnas
            colDetalle: [
                {
                    label: "Folio Recepcion",
                    field: "FOLREC",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Tipo Documento",
                    field: "TIPDOC",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "N° Documento",
                    field: "NUMDOC",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Fecha Documento",
                    field: "FECDOC",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "OC Recepcion",
                    field: "NOMORD",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Total",
                    field: "TOTAL",
                    filterOptions: {
                        enabled: true
                    }
                }
            ],
            col: [
                {
                    label: "Folio",
                    field: "FOLIO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "N° Orden Compra",
                    field: "NUMORD",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Fecha Recepcion",
                    field: "FECDES",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Rut Proveedor",
                    field: "RUTPRO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Nombre Proveedor",
                    field: "NOMPRO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "N° Documento",
                    field: "NUMDOC",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Usuario",
                    field: "USUING",
                    filterOptions: {
                        enabled: true
                    }
                }
            ],
            //Datos Listado
            rows: [],
            listaDetalleOrdenCompra: [],
            listaRecepcion: [],
            listadoProveedores: [],
            listaConsumoInmediato: [
                {
                    id: 1,
                    descripcionConsumoInmediato: "Si"
                },
                {
                    id: 2,
                    descripcionConsumoInmediato: "No"
                }
            ]
        };
    },
    methods: {
        //Metodos Reusables
        onFromChange(selectedDates, dateStr, instance) {
            this.$set(this.configTodateTimePicker, "minDate", dateStr);
        },
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 1000);
        },
        isNumber: function(evt) {
            evt = evt ? evt : window.event;
            var charCode = evt.which ? evt.which : evt.keyCode;
            if (
                charCode > 31 &&
                (charCode < 48 || charCode > 57) &&
                charCode !== 46
            ) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
        volver() {
            try {
                this.$router.push({
                    name: "home"
                });
            } catch (error) {
                console.log(error);
            }
        },
        ImprimirOC() {
            try {
                if (this.numint != 0 && this.folio != 0) {
                    const url =
                        this.localVal +
                        "/api/OrdenCompra/OrdenCompraPDF/" +
                        this.numint;
                    window.open(url, "_blank");
                } else {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "No esta creado el Numero Interno",
                        color: "danger",
                        position: "top-right"
                    });
                }
            } catch (error) {
                console.log(error);
            }
        },
        //PopUp
        popRecepciones() {
            try {
                this.popUpRecepciones = true;
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD
        TraerOrdenCompra() {
            try {
                let data = {
                    NUMINT: this.$route.params.NUMINT
                };

                axios
                    .post(
                        this.localVal +
                            "/api/Mantenedor/GetOrdenCompraIngresadosByCodInterno",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        let listaOC = res.data;
                        if (listaOC.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            let c = listaOC;
                            c.forEach((value, index) => {
                                this.seleccionProveedores.RUTPROV =
                                    value.RUTPRO;
                                this.seleccionProveedores.NOMRAZSOC =
                                    value.NOMPRO;
                                this.descripcionProveedor = value.NOMPRO;
                                this.nsigfe = value.NUMSIGFE;
                                this.nfoliorecepcionado = value.FOLIO;
                                this.anio = value.ANIO;
                            });

                            c = [];
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerDetalleOrdenCompra() {
            try {
                let data = {
                    NUMINT: this.$route.params.NUMINT
                };

                axios
                    .post(
                        this.localVal +
                            "/api/Mantenedor/GetOrdenCompraDetallesIngresadosByCodInterno",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listaDetalleOrdenCompra = res.data;
                        if (this.listaDetalleOrdenCompra.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            let c = this.listaDetalleOrdenCompra;
                            let a = 0;
                            c.forEach((value, index) => {
                                a = parseInt(a) + parseInt(value.TOTAL);
                            });
                            this.valorTotal = a;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerProveedores() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetProveedor", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listadoProveedores = res.data;
                        if (this.listadoProveedores.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los proveedores correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        cargarHoras() {
            try {
                let date = moment().endOf("day");
                this.fechaOrdenCompra = date.format("DD/MM/YYYY").toString();
                this.fechaSistema = date.format("DD/MM/YYYY").toString();
            } catch (error) {
                console.log("No se cargo la ISO hora");
                console.log(error);
            }
        },
        RefreshToken() {
            try {
                let data = {
                    token: localStorage.getItem("token")
                };
                axios
                    .post(this.localVal + "/api/auth/RefreshToken", data)
                    .then(res => {
                        let tok = res.data;
                        if (tok == "") {
                        } else if (tok == false) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No se pudo refrescar su sesion, sera redirigido a el inicio de sesion",
                                color: "danger",
                                position: "top-right"
                            });
                            window.localStorage.clear();
                            window.localStorage.clear();
                            router.push("/pages/login");
                        } else {
                            localStorage.setItem("token", tok);
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        }
    },
    beforeMount() {
        this.RefreshToken();
        this.numint = this.$route.params.NUMINT;
        setTimeout(() => {
            this.TraerOrdenCompra();
            this.TraerDetalleOrdenCompra();
            this.TraerProveedores();
            this.cargarHoras();
            this.openLoadingColor();
        }, 2000);
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1500px;
}
</style>
