<template>
    <div>
        <div class="vx-col md:w-1/1 w-full mb-base">
            <!-- Despacho -->
            <vx-card title="Despacho">
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
                </div>
                <div class="vx-row" v-if="seleccionTipoDespacho.id == 1">
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
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>N° Solicitud</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="nsolicitud"
                        />
                    </div>
                </div>
                <div class="vx-row" v-if="seleccionTipoDespacho.id == 2">
                    <div class="vx-col w-1/6 mt-5">
                        <h6>Fecha Sistema</h6>
                        <flat-pickr
                            :config="configFromdateTimePicker"
                            v-model="fechaSistema"
                            placeholder="Fecha Sistema"
                            class="w-full "
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/6 mt-5">
                        <h6>Fecha Despacho</h6>
                        <flat-pickr
                            :config="configFromdateTimePicker"
                            v-model="fechaDespacho"
                            placeholder="Fecha Despacho"
                            @on-change="onFromChange"
                            class="w-full "
                        />
                    </div>
                    <div class="vx-col w-1/6 mt-5">
                        <h6>Servicio</h6>
                        <v-select
                            v-model="seleccionServicio"
                            placeholder="Activo"
                            class="w-full select-large"
                            label="descripcionServicio"
                            :options="listadoServicios"
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/6 mt-5">
                        <h6>Tipo Despacho</h6>
                        <v-select
                            v-model="seleccionTipoDespacho"
                            placeholder="Activo"
                            class="w-full select-large"
                            label="descripcionTipoDespacho"
                            :options="listadoTipoDespacho"
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/6 mt-5">
                        <h6>N° Solicitud</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="nsolicitud"
                        />
                    </div>
                    <div class="vx-col w-1/6 mt-5">
                        <h6>N° Pedido Especial</h6>
                        <vs-input class="inputx w-full  " v-model="numpesp" />
                    </div>
                </div>
                <div class="vx-row">
                    <div class="vx-col w-full mt-5">
                        <vs-button
                            @click="popArticulosDisponibles"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Agregar Articulos</vs-button
                        >
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
                                            content="Quitar de la Lista"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                popDelDetalleArticulo(
                                                    props.row.id
                                                )
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
                            <div class="vx-col w-1/3 mt-5">
                                <vs-button
                                    @click="ActualizarListado"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Actualizar</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/3 mt-5">
                                <vs-button
                                    @click="volver"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/3 mt-5">
                                <vs-button
                                    @click="RecargarPagina"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Hacer Otro Despacho</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                </div>
            </vx-card>
        </div>
        <vs-popup
            classContent="ListadoArticulosDisponibles"
            title="Listado Articulos Disponibles"
            :active.sync="popUpArticulosDisponibles"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="">
                    <div class="vx-row">
                        <vx-card>
                            <vue-good-table
                                :columns="colArticulosDisponibles"
                                :rows="listaArticulosDisponibles"
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
                                            props.column.field ===
                                                'diasVencimiento'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-chip
                                            color="danger"
                                            v-if="
                                                props.row.diasVencimiento < 91
                                            "
                                            type="text"
                                            style="width:100px"
                                            >{{
                                                props.row.diasVencimiento
                                            }}</vs-chip
                                        >
                                        <vs-chip
                                            v-else-if="
                                                props.row.diasVencimiento >
                                                    90 &&
                                                    props.row.diasVencimiento <
                                                        181
                                            "
                                            color="warning"
                                            type="text"
                                            style="width:100px"
                                            >{{
                                                props.row.diasVencimiento
                                            }}</vs-chip
                                        >
                                        <vs-chip
                                            v-else
                                            color="success"
                                            type="text"
                                            style="width:100px"
                                            >{{
                                                props.row.diasVencimiento
                                            }}</vs-chip
                                        >
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'CANTIDAD'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-input
                                            v-model="props.row.CANTIDAD"
                                            type="text"
                                            style="width:100px"
                                            @keypress="isNumber($event)"
                                            @keyup.enter="
                                                AgregarArticuloDisponible(
                                                    props.row.saldoCorrecto,
                                                    props.row.NOMBRE,
                                                    props.row.CODBAR,
                                                    props.row.LOTE,
                                                    props.row.UNIMED,
                                                    props.row.CODART,
                                                    props.row.diasVencimiento,
                                                    props.row.fechaVencimiento,
                                                    props.row.PREUNI,
                                                    props.row.CANTIDAD
                                                )
                                            "
                                        ></vs-input>
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'action'
                                        "
                                    >
                                        <plus-circle-icon
                                            content="Agregar Articulo al listado"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                AgregarArticuloDisponible(
                                                    props.row.saldoCorrecto,
                                                    props.row.NOMBRE,
                                                    props.row.CODBAR,
                                                    props.row.LOTE,
                                                    props.row.UNIMED,
                                                    props.row.CODART,
                                                    props.row.diasVencimiento,
                                                    props.row.fechaVencimiento,
                                                    props.row.PREUNI,
                                                    props.row.CANTIDAD
                                                )
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
                        </vx-card>
                    </div>
                </vx-card>
                <div class="vx-row"></div>
            </div>
        </vs-popup>
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
                allowInput: true,
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
            popUpArticulosDisponibles: false,
            numint: 0,
            fechaSistema: null,
            fechaDespacho: null,
            nlibropedido: "-",
            nsolicitud: "",
            Observaciones: "-",
            valorTotal: 0,
            saldoCorrecto: 0,
            NOMBRE: "",
            CODBAR: "",
            LOTE: "",
            UNIMED: "",
            CODART: "",
            numpesp: 0,
            diasVencimiento: 0,
            fechaVencimiento: 0,
            PREUNI: 0,
            //Selecciones de Datos
            seleccionServicio: {
                id: 0,
                descripcionServicio: ""
            },
            seleccionTipoDespacho: {
                id: 0,
                descripcionTipoDespacho: ""
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
                    label: "Opciones",
                    field: "action"
                }
            ],
            colArticulosDisponibles: [
                {
                    label: "N° Interno",
                    field: "CODART",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Descripcion",
                    field: "NOMBRE",
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
                    label: "Fecha Vencimiento",
                    field: "fechaVencimiento",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Alerta",
                    field: "diasVencimiento",
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
                    label: "Codigo Barra",
                    field: "CODBAR",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Saldo",
                    field: "saldoCorrecto",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Cantidad a Despachar",
                    field: "CANTIDAD",
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
            listaArticulosDisponibles: [],
            listaArticulosActuales: [],
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
                    name: "ListadoDespachoAbierto"
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
        popDelDetalleArticulo(idArt) {
            try {
                let data = {
                    id: idArt
                };
                axios
                    .post(
                        this.localVal +
                            "/api/Despachos/PostQuitarArticuloDespacho",
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
                                    "Se no quito el articulo, intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Finalizado",
                                text: "Articulo quitado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.TraerDetalleDespacho();
                            this.TraerArticulosDisponibles();
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        ActualizarListado() {
            try {
                if (this.seleccionTipoDespacho.id == 1) {
                    this.numpesp = 0;
                }
                let data = {
                    NUMINT: this.numint,
                    FECDES: moment(this.fechaDespacho, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    idServicio: this.seleccionServicio.id,
                    NOMSER: this.seleccionServicio.descripcionServicio,
                    NUMLIBRO: this.nlibropedido,
                    TIPDESP: this.seleccionTipoDespacho.descripcionTipoDespacho,
                    NUMSOL: this.nsolicitud,
                    OBS: this.Observaciones.toUpperCase(),
                    NUMPESP: this.numpesp
                };

                axios
                    .post(this.localVal + "/api/Despachos/PutDespacho", data, {
                        headers: {
                            Authorization:
                                `Bearer ` + localStorage.getItem("token")
                        }
                    })
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
        TraerUltimoNFolio() {
            try {
                axios
                    .get(
                        this.localVal +
                            "/api/Despachos/GetUltimoNFolioDespacho",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        let data = res.data[0].FOLIO;
                        if (
                            data == 0 ||
                            data == null ||
                            data == [] ||
                            data == {}
                        ) {
                            this.folio = 1;
                        } else {
                            this.folio = data + 1;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerArticulosActuales() {
            try {
                axios
                    .get(
                        this.localVal +
                            "/api/Despachos/GetDetallesArticulosDisponibles",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listaArticulosActuales = res.data;
                        if (this.listaArticulosActuales.length < 0) {
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
        CerrarDespacho() {
            try {
                let validar = false;
                let nomarticulo = "A";
                this.TraerArticulosActuales();
                setTimeout(() => {
                    let c = this.listaArticulosActuales;
                    let d = this.listaDespachoArticulos;
                    d.forEach((value, index) => {
                        c.forEach((val, ind) => {
                            if (
                                value.CODART == val.CODART &&
                                value.LOTE == val.LOTE &&
                                parseInt(val.saldoCorrecto) <
                                    parseInt(value.CANTIDAD)
                            ) {
                                nomarticulo = value.NOMART;
                                validar = true;
                            }
                        });
                    });
                    if (validar == true) {
                        this.$vs.notify({
                            time: 5000,
                            title: "Error",
                            text:
                                "Articulo " +
                                nomarticulo +
                                " sin saldo suficiente,revise los datos e intente nuevamente ",
                            color: "danger",
                            position: "top-right"
                        });
                    } else {
                        this.TraerUltimoNFolio();
                        setTimeout(() => {
                            if (this.listaDespachoArticulos.length < 1) {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No existen datos en el detalle para generar un N° de Folio",
                                    color: "danger",
                                    position: "top-right"
                                });
                            } else if (this.folio == 0) {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text: "No se pudo generar un N° de Folio",
                                    color: "danger",
                                    position: "top-right"
                                });
                            } else {
                                let data = {
                                    NUMINT: this.numint,
                                    FOLIO: this.folio
                                };
                                axios
                                    .post(
                                        this.localVal +
                                            "/api/Despachos/CerrarDespacho",
                                        data,
                                        {
                                            headers: {
                                                Authorization:
                                                    `Bearer ` +
                                                    localStorage.getItem(
                                                        "token"
                                                    )
                                            }
                                        }
                                    )
                                    .then(res => {
                                        let data = res.data;
                                        if (data == true) {
                                            this.$vs.notify({
                                                time: 5000,
                                                title: "Finalizado",
                                                text:
                                                    "Despacho Cerrado, sera redirigido a otra ventana",
                                                color: "success",
                                                position: "top-right"
                                            });
                                            this.$router.push({
                                                name: "ListadoDespachosCerrados"
                                            });
                                        }
                                    });
                            }
                        }, 2000);
                    }
                }, 1000);
            } catch (error) {
                console.log(error);
            }
        },
        popArticulosDisponibles() {
            try {
                if (
                    this.fechaDespacho != null &&
                    this.seleccionTipoDespacho.id != 0 &&
                    this.seleccionServicio.id != 0
                ) {
                    this.popUpArticulosDisponibles = true;
                } else {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "Debe seleccionar la Fecha de despacho, Servicio y Tipo de Despacho para poder agregar articulos",
                        color: "danger",
                        position: "top-right"
                    });
                }
            } catch (error) {
                console.log(error);
            }
        },
        AgregarArticuloDisponible(
            saldoCorrecto,
            NOMBRE,
            CODBAR,
            LOTE,
            UNIMED,
            CODART,
            diasVencimiento,
            fechaVencimiento,
            PRECIO,
            cantidad
        ) {
            try {
                let nombreUsuario =
                    localStorage.getItem("nombre") +
                    " " +
                    localStorage.getItem("apellido");
                if (parseInt(saldoCorrecto) < parseInt(cantidad)) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "La cantidad ingresada supera el saldo existente, ingrese otro valor e intentelo nuevamente",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    if (
                        this.numint == 0 &&
                        this.fechaDespacho != null &&
                        this.seleccionTipoDespacho.id != 0 &&
                        this.seleccionServicio.id != 0
                    ) {
                        axios
                            .get(
                                this.localVal +
                                    "/api/Despachos/GetUltimoNInternoDespacho",
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            localStorage.getItem("token")
                                    }
                                }
                            )
                            .then(res => {
                                let nint = res.data[0].NUMINT;
                                if (
                                    nint == 0 ||
                                    nint == null ||
                                    nint == [] ||
                                    nint == {}
                                ) {
                                    this.numint = 1;
                                    let data = {};
                                    if (fechaVencimiento == "No tiene Fecha") {
                                        data = {
                                            NUMINT: this.numint,
                                            FECSYS: moment(
                                                this.fechaSistema,
                                                "DD-MM-YYYY"
                                            ).format("YYYY-MM-DD"),
                                            FECDES: moment(
                                                this.fechaDespacho,
                                                "DD-MM-YYYY"
                                            ).format("YYYY-MM-DD"),
                                            NOMSER: this.seleccionServicio
                                                .descripcionServicio,
                                            TIPDESP: this.seleccionTipoDespacho
                                                .descripcionTipoDespacho,
                                            NUMSOL: this.nsolicitud,
                                            NUMLIBRO: this.nlibropedido,
                                            saldoCorrecto: saldoCorrecto,
                                            NOMART: NOMBRE,
                                            CODBAR: CODBAR,
                                            LOTE: LOTE,
                                            UNIMED: UNIMED,
                                            CODART: CODART,
                                            diasVencimiento: diasVencimiento,
                                            PRECIO: PRECIO,
                                            CANTIDAD: cantidad,
                                            USUING: nombreUsuario.toUpperCase(),
                                            NUMPESP: this.numpesp
                                        };
                                    } else {
                                        data = {
                                            NUMINT: this.numint,
                                            FECSYS: moment(
                                                this.fechaSistema,
                                                "DD-MM-YYYY"
                                            ).format("YYYY-MM-DD"),
                                            FECDES: moment(
                                                this.fechaDespacho,
                                                "DD-MM-YYYY"
                                            ).format("YYYY-MM-DD"),
                                            NOMSER: this.seleccionServicio
                                                .descripcionServicio,
                                            TIPDESP: this.seleccionTipoDespacho
                                                .descripcionTipoDespacho,
                                            NUMSOL: this.nsolicitud,
                                            NUMLIBRO: this.nlibropedido,
                                            saldoCorrecto: saldoCorrecto,
                                            NOMART: NOMBRE,
                                            CODBAR: CODBAR,
                                            LOTE: LOTE,
                                            UNIMED: UNIMED,
                                            CODART: CODART,
                                            diasVencimiento: diasVencimiento,
                                            FECVEN: moment(
                                                fechaVencimiento
                                            ).format("YYYY-MM-DD"),
                                            PRECIO: PRECIO,
                                            CANTIDAD: cantidad,
                                            USUING: nombreUsuario.toUpperCase(),
                                            NUMPESP: this.numpesp
                                        };
                                    }

                                    axios
                                        .post(
                                            this.localVal +
                                                "/api/Despachos/PostDespacho",
                                            data,
                                            {
                                                headers: {
                                                    Authorization:
                                                        `Bearer ` +
                                                        localStorage.getItem(
                                                            "token"
                                                        )
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
                                                        "Se no guardaron los datos, intentelo nuevamente",
                                                    color: "danger",
                                                    position: "top-right"
                                                });
                                            } else {
                                                this.$vs.notify({
                                                    time: 5000,
                                                    title: "Finalizado",
                                                    text:
                                                        "Datos Guardados Correctamente",
                                                    color: "success",
                                                    position: "top-right"
                                                });
                                                //this.popUpArticulosDisponibles = false;
                                                this.TraerArticulosDisponibles();
                                                this.TraerDetalleDespacho();
                                            }
                                        });
                                } else {
                                    this.numint = nint + 1;
                                    let data = {};
                                    if (fechaVencimiento == "No tiene Fecha") {
                                        data = {
                                            NUMINT: this.numint,
                                            FECSYS: moment(
                                                this.fechaSistema,
                                                "DD-MM-YYYY"
                                            ).format("YYYY-MM-DD"),
                                            FECDES: moment(
                                                this.fechaDespacho,
                                                "DD-MM-YYYY"
                                            ).format("YYYY-MM-DD"),
                                            NOMSER: this.seleccionServicio
                                                .descripcionServicio,
                                            TIPDESP: this.seleccionTipoDespacho
                                                .descripcionTipoDespacho,
                                            NUMSOL: this.nsolicitud,
                                            NUMLIBRO: this.nlibropedido,
                                            saldoCorrecto: saldoCorrecto,
                                            NOMART: NOMBRE,
                                            CODBAR: CODBAR,
                                            LOTE: LOTE,
                                            UNIMED: UNIMED,
                                            CODART: CODART,
                                            diasVencimiento: diasVencimiento,
                                            PRECIO: PRECIO,
                                            CANTIDAD: cantidad,
                                            USUING: nombreUsuario.toUpperCase(),
                                            NUMPESP: this.numpesp
                                        };
                                    } else {
                                        data = {
                                            NUMINT: this.numint,
                                            FECSYS: moment(
                                                this.fechaSistema,
                                                "DD-MM-YYYY"
                                            ).format("YYYY-MM-DD"),
                                            FECDES: moment(
                                                this.fechaDespacho,
                                                "DD-MM-YYYY"
                                            ).format("YYYY-MM-DD"),
                                            NOMSER: this.seleccionServicio
                                                .descripcionServicio,
                                            TIPDESP: this.seleccionTipoDespacho
                                                .descripcionTipoDespacho,
                                            NUMSOL: this.nsolicitud,
                                            NUMLIBRO: this.nlibropedido,
                                            saldoCorrecto: saldoCorrecto,
                                            NOMART: NOMBRE,
                                            CODBAR: CODBAR,
                                            LOTE: LOTE,
                                            UNIMED: UNIMED,
                                            CODART: CODART,
                                            diasVencimiento: diasVencimiento,
                                            FECVEN: moment(
                                                fechaVencimiento
                                            ).format("YYYY-MM-DD"),
                                            PRECIO: PRECIO,
                                            CANTIDAD: cantidad,
                                            USUING: nombreUsuario.toUpperCase(),
                                            NUMPESP: this.numpesp
                                        };
                                    }

                                    axios
                                        .post(
                                            this.localVal +
                                                "/api/Despachos/PostDespacho",
                                            data,
                                            {
                                                headers: {
                                                    Authorization:
                                                        `Bearer ` +
                                                        localStorage.getItem(
                                                            "token"
                                                        )
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
                                                        "Se no guardaron los datos, intentelo nuevamente",
                                                    color: "danger",
                                                    position: "top-right"
                                                });
                                            } else {
                                                this.$vs.notify({
                                                    time: 5000,
                                                    title: "Finalizado",
                                                    text:
                                                        "Datos Guardados Correctamente",
                                                    color: "success",
                                                    position: "top-right"
                                                });
                                                //this.popUpArticulosDisponibles = false;
                                                this.TraerArticulosDisponibles();
                                                this.TraerDetalleDespacho();
                                            }
                                        });
                                }
                            });
                    } else {
                        let data = {};
                        if (fechaVencimiento == "No tiene Fecha") {
                            data = {
                                NUMINT: this.numint,
                                FECSYS: moment(
                                    this.fechaSistema,
                                    "DD-MM-YYYY"
                                ).format("YYYY-MM-DD"),
                                FECDES: moment(
                                    this.fechaDespacho,
                                    "DD-MM-YYYY"
                                ).format("YYYY-MM-DD"),
                                NOMSER: this.seleccionServicio
                                    .descripcionServicio,
                                saldoCorrecto: saldoCorrecto,
                                NOMART: NOMBRE,
                                CODBAR: CODBAR,
                                LOTE: LOTE,
                                UNIMED: UNIMED,
                                CODART: CODART,
                                diasVencimiento: diasVencimiento,
                                PRECIO: PRECIO,
                                CANTIDAD: cantidad,
                                USUING: nombreUsuario.toUpperCase()
                            };
                        } else {
                            data = {
                                NUMINT: this.numint,
                                FECSYS: moment(
                                    this.fechaSistema,
                                    "DD-MM-YYYY"
                                ).format("YYYY-MM-DD"),
                                FECDES: moment(
                                    this.fechaDespacho,
                                    "DD-MM-YYYY"
                                ).format("YYYY-MM-DD"),
                                NOMSER: this.seleccionServicio
                                    .descripcionServicio,
                                saldoCorrecto: saldoCorrecto,
                                NOMART: NOMBRE,
                                CODBAR: CODBAR,
                                LOTE: LOTE,
                                UNIMED: UNIMED,
                                CODART: CODART,
                                diasVencimiento: diasVencimiento,

                                FECVEN: moment(fechaVencimiento).format(
                                    "YYYY-MM-DD"
                                ),
                                PRECIO: PRECIO,
                                CANTIDAD: cantidad,
                                USUING: nombreUsuario.toUpperCase()
                            };
                        }

                        axios
                            .post(
                                this.localVal +
                                    "/api/Despachos/PostDetalleDespacho",
                                data,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            localStorage.getItem("token")
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
                                            "Se no guardaron los datos, intentelo nuevamente",
                                        color: "danger",
                                        position: "top-right"
                                    });
                                } else {
                                    this.$vs.notify({
                                        time: 5000,
                                        title: "Finalizado",
                                        text: "Datos Guardados Correctamente",
                                        color: "success",
                                        position: "top-right"
                                    });
                                    //this.popUpArticulosDisponibles = false;
                                    this.TraerArticulosDisponibles();
                                    this.TraerDetalleDespacho();
                                }
                            });
                    }
                }
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
                                nomser = value.NOMSER;
                                this.Observaciones = value.OBS;
                                this.numpesp = value.NUMPESP;
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
        TraerArticulosDisponibles() {
            try {
                axios
                    .get(
                        this.localVal +
                            "/api/Despachos/GetDetallesArticulosDisponibles",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listaArticulosDisponibles = res.data;
                        if (this.listaArticulosDisponibles.length < 0) {
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
            this.TraerArticulosDisponibles();
            this.TraerDespacho();
            this.TraerDetalleDespacho();
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
