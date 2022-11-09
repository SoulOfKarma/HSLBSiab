<template>
    <div>
        <div class="vx-col md:w-1/1 w-full mb-base">
            <!-- Despacho -->
            <vx-card title="Despacho Cerrado">
                <div class="vx-row">
                    <div
                        class="vx-col w-full mt-5"
                        v-if="listaDespachoArticulos.length > 0"
                    >
                        <h6>N° Interno</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="numint"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Fecha Sistema</h6>
                        <flat-pickr
                            :config="configFromdateTimePicker"
                            v-model="fechaSistema"
                            placeholder="Fecha Sistema"
                            class="w-full "
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Fecha Despacho</h6>
                        <flat-pickr
                            :config="configFromdateTimePicker"
                            v-model="fechaDespacho"
                            placeholder="Fecha Despacho"
                            @on-change="onFromChange"
                            disabled
                            class="w-full "
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Servicio</h6>
                        <v-select
                            v-model="seleccionServicio"
                            placeholder="Activo"
                            class="w-full select-large"
                            label="descripcionServicio"
                            :options="listadoServicios"
                            disabled
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Tipo Despacho</h6>
                        <v-select
                            v-model="seleccionTipoDespacho"
                            placeholder="Activo"
                            class="w-full select-large"
                            label="descripcionTipoDespacho"
                            :options="listadoTipoDespacho"
                            disabled
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>N° Solicitud</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="nsolicitud"
                            disabled
                        />
                    </div>
                </div>
                <br />
                <!-- Detalles Articulos -->
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <vx-card title="">
                        <div class="vx-row">
                            <vue-good-table
                                class="w-full"
                                :columns="colDespachoArticulos"
                                :rows="listaDespachoArticulos"
                                :pagination-options="PageOptions"
                                theme="black-rhino"
                            >
                                <template slot="table-row" slot-scope="props">
                                    <!-- Column: Name -->
                                    <span
                                        v-if="props.column.field === 'fullName'"
                                        class="text-nowrap"
                                    >
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'action'
                                        "
                                    >
                                        <plus-circle-icon
                                            v-if="validarUsuario != 5"
                                            content="Anular Articulo"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                popAnularArticulo(props.row.id)
                                            "
                                        ></plus-circle-icon>
                                        <plus-circle-icon
                                            v-if="validarUsuario != 5"
                                            content="Revertir Anulacion Articulo"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                popRAnularArticulo(props.row.id)
                                            "
                                        ></plus-circle-icon>
                                    </span>
                                    <!-- Column: Common -->
                                    <span v-else>
                                        {{
                                            props.formattedRow[
                                                props.column.field
                                            ]
                                        }}
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
                                <h6>Observaciones</h6>
                                <quill-editor
                                    class="w-full"
                                    v-model="Observaciones"
                                    :options="editorOption"
                                >
                                    <div id="toolbar" slot="toolbar"></div>
                                </quill-editor>
                            </div>
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
                        </div>
                        <br /><br />
                    </vx-card>
                </div>
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    v-if="validarUsuario == 5"
                                    @click="volver"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    v-if="validarUsuario == 5"
                                    @click="ImprimirDatos"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Imprimir</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <vs-button
                                    v-if="validarUsuario != 5"
                                    @click="volver"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <vs-button
                                    v-if="validarUsuario != 5"
                                    @click="ActualizarListado"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Actualizar Observacion</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <vs-button
                                    v-if="validarUsuario != 5"
                                    @click="ImprimirDatos"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Imprimir</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <vs-button
                                    v-if="validarUsuario != 5"
                                    @click="RecargarPagina"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Hacer Otro Despacho</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <vs-button
                                    v-if="validarUsuario != 5"
                                    @click="popAnularTodo"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Anular Todo</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/6 mt-5">
                                <vs-button
                                    v-if="validarUsuario != 5"
                                    @click="AgregarListadoFirmaUsers"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Firmar Digitalmente</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                </div>
            </vx-card>
            <vs-popup
                classContent="RevertirAnulacion"
                title="Revertir Anulacion"
                :active.sync="popUpRAnularArticulo"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="popUpRAnularArticulo == false"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver
                                </vs-button>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="popRAnularDetalleArticulo"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Revertir Anulacion</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <vs-popup
                classContent="Anulacion"
                title="Anulacion"
                :active.sync="popUpAnularArticulo"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-full mt-5">
                                <h6>Seleccione Tipo de Anulacion</h6>
                                <v-select
                                    v-model="seleccionAnulacion"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="NOMMOT"
                                    :options="listadoAnulacion"
                                ></v-select>
                            </div>
                            <div class="vx-col w-full mt-5">
                                <vs-button
                                    @click="popAnularDetalleArticulo"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Anular</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <vs-popup
                classContent="Anulacion"
                title="Anulacion"
                :active.sync="popUpAnularTodo"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-full mt-5">
                                <h6>Seleccione Tipo de Anulacion</h6>
                                <v-select
                                    v-model="seleccionAnulacion"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="NOMMOT"
                                    :options="listadoAnulacion"
                                ></v-select>
                            </div>
                            <div class="vx-col w-full mt-5">
                                <vs-button
                                    @click="AnularTodo"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Anular</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
        </div>
    </div>
</template>
<script>
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import moment from "moment";
import axios from "axios";
import vSelect from "vue-select";
import router from "@/router";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import "vue-good-table/dist/vue-good-table.css";
import { VueGoodTable } from "vue-good-table";
import { PlusCircleIcon } from "vue-feather-icons";
import Vue from "vue";
import VueTippy, { TippyComponent } from "vue-tippy";
import store from "../ScriptMenus/store.js";
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
            //Datos Generales
            PageOptions: store.state.PageOptions,
            validarUsuario: localStorage.getItem("permiso_usuario"),
            popUpAnularArticulo: false,
            popUpAnularTodo: false,
            popUpRAnularArticulo: false,
            numint: 0,
            fechaSistema: null,
            fechaDespacho: null,
            nlibropedido: "",
            nsolicitud: "",
            Observaciones: "-",
            valorTotal: 0,
            saldoCorrecto: 0,
            NOMBRE: "",
            CODBAR: "",
            LOTE: "",
            UNIMED: "",
            CODART: "",
            diasVencimiento: 0,
            fechaVencimiento: 0,
            PREUNI: 0,
            idAnulacion: 0,
            //Selecciones de Datos
            seleccionServicio: {
                id: 0,
                descripcionServicio: ""
            },
            seleccionTipoDespacho: {
                id: 0,
                descripcionTipoDespacho: ""
            },
            seleccionAnulacion: {
                id: 0,
                CODMOT: "",
                NOMMOT: ""
            },
            //Columnas Lista de Datos
            colDespachoArticulos: [
                {
                    label: "N° Interno",
                    field: "CODART",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Codigo Barra",
                    field: "CODBAR",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Descripcion",
                    field: "NOMART",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Unidad Medida",
                    field: "UNIMED",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Precio Unitario",
                    field: "PRECIO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Fecha Vencimiento",
                    field: "FECVEN",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Lote",
                    field: "LOTE",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Cantidad Despachada",
                    field: "CANTIDAD",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Valor Total Despacho",
                    field: "VALORTOTALDESP",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Anulado?",
                    field: "NOMMOT",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ],
            //Listado de Datos
            listadoServicios: [],
            listaDespachoArticulos: [],
            listadoAnulacion: [],
            listadoTipoDespacho: [
                {
                    id: 1,
                    descripcionTipoDespacho: "Solicitud Pedidos"
                },
                {
                    id: 2,
                    descripcionTipoDespacho: "Pedido Especial"
                }
            ]
        };
    },
    methods: {
        //Metodos Reusables
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
        onFromChange(selectedDates, dateStr, instance) {
            this.$set(this.configTodateTimePicker, "minDate", dateStr);
        },
        volver() {
            try {
                this.$router.push({
                    name: "ListadoDespachosCerrados"
                });
            } catch (error) {
                console.log(error);
            }
        },
        RecargarPagina() {
            try {
                this.$router.push({
                    name: "SolicitudPedidos"
                });
            } catch (error) {
                console.log(error);
            }
        },
        ActualizarListado() {
            try {
                let data = {
                    NUMINT: this.numint,
                    OBS: this.Observaciones.toUpperCase()
                };

                axios
                    .post(
                        this.localVal +
                            "/api/Despachos/PutDespachoObservaciones",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        let dat = res.data;
                        if (dat == false) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "Error al Actualizar los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Actualizado",
                                text: "Datos actualizados correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.TraerDespacho();
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        popAnularArticulo(id) {
            try {
                this.idAnulacion = 0;
                this.idAnulacion = id;
                this.popUpAnularArticulo = true;
            } catch (error) {
                console.log(error);
            }
        },
        popRAnularArticulo(id) {
            try {
                this.idAnulacion = 0;
                this.idAnulacion = id;
                this.popUpRAnularArticulo = true;
            } catch (error) {
                console.log(error);
            }
        },
        ImprimirDatos() {
            try {
                if (this.numint != 0) {
                    const url =
                        this.localVal +
                        "/api/Despacho/DespachoPDF/" +
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
        popAnularTodo() {
            try {
                this.popUpAnularTodo = true;
            } catch (error) {
                console.log(error);
            }
        },
        AnularTodo() {
            try {
                let data = {
                    NUMINT: this.numint,
                    CODMOT: this.seleccionAnulacion.CODMOT,
                    NOMMOT: this.seleccionAnulacion.NOMMOT
                };
                axios
                    .post(
                        this.localVal + "/api/Despachos/PostAnularTodo",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        let dat = res.data;
                        if (dat == false) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No se pudo anular el despacho, intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Finalizado",
                                text: "Despacho anulado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.popUpAnularTodo = false;
                            this.TraerDetalleDespacho();
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        popAnularDetalleArticulo() {
            try {
                let data = {
                    id: this.idAnulacion,
                    CODMOT: this.seleccionAnulacion.CODMOT,
                    NOMMOT: this.seleccionAnulacion.NOMMOT
                };
                axios
                    .post(
                        this.localVal + "/api/Despachos/PostAnularArticulo",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        let dat = res.data;
                        if (dat == false) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No se pudo anular el articulo, intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Finalizado",
                                text: "Articulo anulado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.popUpAnularArticulo = false;
                            this.TraerDetalleDespacho();
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        popRAnularDetalleArticulo() {
            try {
                let data = {
                    id: this.idAnulacion
                };
                axios
                    .post(
                        this.localVal + "/api/Despachos/PostRAnularArticulo",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        let dat = res.data;
                        if (dat == false) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No se pudo Revertir la anulacion del articulo, intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Finalizado",
                                text: "Articulo revertido Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.popUpRAnularArticulo = false;
                            this.TraerDetalleDespacho();
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD
        TraerServicio() {
            try {
                axios
                    .get(
                        this.localVal + "/api/Mantenedor/GetServiciosActivos",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        let c = res.data;
                        let valor = 0;

                        let nombre = "";
                        let d = [];
                        c.forEach((val, index) => {
                            if (valor == 0) {
                                d.push(val);
                                valor = 1;
                                nombre = val.descripcionServicio;
                            } else if (nombre != val.descripcionServicio) {
                                d.push(val);
                                nombre = "";
                                nombre = val.descripcionServicio;
                            }
                        });

                        this.listadoServicios = d;
                        if (this.listadoServicios.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de los servicios correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerAnulaciones() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetAnulacion", {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listadoAnulacion = res.data;
                        if (this.listadoAnulacion.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerDespacho() {
            try {
                let numint = {
                    NUMINT: this.$route.params.NUMINT
                };
                axios
                    .post(
                        this.localVal + "/api/Despachos/GetDespachos",
                        numint,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        let data = res.data;
                        if (data.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de los servicios correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            let nomser = "";
                            data.forEach((value, index) => {
                                this.numint = this.$route.params.NUMINT;
                                this.fechaSistema = moment(value.FECSYS)
                                    .format("DD/MM/YYYY")
                                    .toString();
                                this.fechaDespacho = moment(value.FECDES)
                                    .format("DD/MM/YYYY")
                                    .toString();
                                this.nlibropedido = value.NUMLIBRO;
                                this.nsolicitud = value.NUMSOL;
                                this.Observaciones = value.OBS;
                                nomser = value.NOMSER;
                                if (value.TIPDESP == "Solicitud Pedidos") {
                                    this.seleccionTipoDespacho = {
                                        id: 1,
                                        descripcionTipoDespacho:
                                            "Solicitud Pedidos"
                                    };
                                } else {
                                    this.seleccionTipoDespacho = {
                                        id: 2,
                                        descripcionTipoDespacho:
                                            "Pedido Especial"
                                    };
                                }
                            });
                            let c = this.listadoServicios;
                            c.forEach((val, index) => {
                                if (nomser == val.descripcionServicio) {
                                    this.seleccionServicio = {
                                        id: val.id,
                                        descripcionServicio:
                                            val.descripcionServicio
                                    };
                                }
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerDetalleDespacho() {
            try {
                let numint = {
                    NUMINT: this.$route.params.NUMINT
                };
                axios
                    .post(
                        this.localVal + "/api/Despachos/GetDespachoDetalles",
                        numint,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listaDespachoArticulos = res.data;
                        if (this.listaDespachoArticulos.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            this.valorTotal = 0;
                            this.listaDespachoArticulos.forEach(
                                (value, index) => {
                                    this.valorTotal =
                                        parseInt(this.valorTotal) +
                                        parseInt(value.VALORTOTALDESP);
                                }
                            );
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        //Firma Digital
        AgregarListadoFirmaUsers() {
            try {
                let run = localStorage.getItem("run");
                if (run.length == 10) {
                    run = run.substring(0, 8);
                } else if (run == 9) {
                    run = run.substring(0, 7);
                }

                let data = {
                    RUN: run,
                    idPerfil: localStorage.getItem("permiso_usuario"),
                    NUMINT: this.numint
                };

                axios
                    .post(
                        this.localVal + "/api/Firma/PostUsuarioDespachosFirma",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        let resp = res.data;
                        this.GenerarCifrado(resp, this.numint);
                    });
            } catch (error) {
                console.log(error);
            }
        },
        GenerarCifrado(data, numint) {
            try {
                let secreto = "4a191562d7b2476d8dcb13f265b4c7b1";
                const jwt = require("jsonwebtoken");
                let date = moment().add(30, "minutes");
                let fecha = date.format("YYYY-MM-DDTHH:mm:ss").toString();

                let c = data;

                let token = "";
                let token1 = "";
                let token2 = "";

                let codPerfil = "";
                let codPerfil1 = "";
                let codPerfil2 = "";

                let descServicio = "";
                let descServicio1 = "";
                let descServicio2 = "";

                let nombreUsuario = "";
                let nombreUsuario1 = "";
                let nombreUsuario2 = "";

                let doc = "";

                let count = 0;

                c.forEach((value, index) => {
                    doc = value.NUMINT.toString() + ".pdf";
                    if (value.idPerfil == 1) {
                        const user = {
                            entity: "Hospital San Luis de Buin - Paine",
                            run: value.RUN,
                            expiration: fecha,
                            purpose: "Desatendido"
                        };

                        token = jwt.sign(user, secreto, {
                            expiresIn: 60 * 30,
                            algorithm: "HS256"
                        });
                        codPerfil = value.idPerfil;
                        descServicio = value.descripcionServicio;
                        nombreUsuario = value.nombre;
                        count = count + 1;
                    } else if (value.idPerfil == 2) {
                        const user = {
                            entity: "Hospital San Luis de Buin - Paine",
                            run: value.RUN,
                            expiration: fecha,
                            purpose: "Desatendido"
                        };

                        token1 = jwt.sign(user, secreto, {
                            expiresIn: 60 * 30,
                            algorithm: "HS256"
                        });
                        codPerfil1 = value.idPerfil;
                        descServicio1 = value.descripcionServicio;
                        nombreUsuario1 = value.nombre;
                        count = count + 1;
                    } else if (value.idPerfil == 3) {
                        const user = {
                            entity: "Hospital San Luis de Buin - Paine",
                            run: value.RUN,
                            expiration: fecha,
                            purpose: "Desatendido"
                        };

                        token2 = jwt.sign(user, secreto, {
                            expiresIn: 60 * 30,
                            algorithm: "HS256"
                        });
                        codPerfil2 = value.idPerfil;
                        descServicio2 = value.descripcionServicio;
                        nombreUsuario2 = value.nombre;
                        count = count + 1;
                    }
                });

                let dat = {
                    api_token_key: "d7f01566-48df-4a67-8388-4fc0b85d5c37",
                    token: token,
                    token1: token1,
                    token2: token2,
                    cont: doc.toString(),
                    link: this.localVal + "/Verificacion",
                    codPerfil: codPerfil,
                    codPerfil1: codPerfil1,
                    codPerfil2: codPerfil2,
                    descServicio: descServicio,
                    descServicio1: descServicio1,
                    descServicio2: descServicio2,
                    nombreUsuario: nombreUsuario,
                    nombreUsuario1: nombreUsuario1,
                    nombreUsuario2: nombreUsuario2,
                    count: count,
                    NUMINT: numint
                };

                axios
                    .post(
                        this.localVal + "/api/Firma/FirmaDigitalDespachoArray",
                        dat,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        let tok = res.data;
                        const url =
                            this.localVal + "/DocumentosFirmados/" + tok;
                        window.open(url, "_blank");
                    });
            } catch (error) {
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
        setTimeout(() => {
            this.TraerServicio();
            this.TraerDespacho();
            this.TraerDetalleDespacho();
            this.TraerAnulaciones();
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
