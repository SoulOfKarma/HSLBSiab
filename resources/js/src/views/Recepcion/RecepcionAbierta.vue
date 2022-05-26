<template>
    <div>
        <div class="vx-col md:w-1/1 w-full mb-base">
            <vx-card title="Recepcion">
                <div class="vx-row">
                    <div class="vx-col w-full mt-5">
                        <vs-button
                            @click="popArticulos"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Buscar Articulo</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/4 mt-5">
                        <h6>Fecha Sistema</h6>
                        <flat-pickr
                            :config="configFromdateTimePicker"
                            v-model="fechaSistema"
                            placeholder="Fecha Sistema"
                            class="w-full "
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/4 mt-5">
                        <h6>Fecha Inicio</h6>
                        <flat-pickr
                            :config="configFromdateTimePicker"
                            v-model="fechaRecepcion"
                            placeholder="Fecha Inicio"
                            @on-change="onFromChange"
                            class="w-full "
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/4 mt-5">
                        <h6>Proveedor</h6>
                        <v-select
                            v-model="seleccionProveedores"
                            placeholder="Activo"
                            class="w-full select-large"
                            label="RUTPROV"
                            :options="listadoProveedores"
                            @input="setProveedor"
                            disabled
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/4 mt-5">
                        <h6>Nombre Proveedor</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="descripcionProveedor"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Tipo Documento</h6>
                        <v-select
                            v-model="seleccionTipoDocumento"
                            placeholder="Activo"
                            class="w-full select-large"
                            label="descripcionDocumento"
                            :options="listaTipoDocumento"
                            disabled
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>N° Documento</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="ndocumento"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Fecha Documento</h6>
                        <flat-pickr
                            :config="configFromdateTimePicker"
                            v-model="fechaDocumento"
                            @on-change="onFromChange"
                            class="w-full "
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>N° Orden Compra</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="nordencompra"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>N° RIB</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="nrib"
                            disabled
                        />
                    </div>
                </div>
                <br />
                <div class="vx-row">
                    <div class="vx-col w-1/3 mt-5">
                        <h6>
                            Codigo de Barra
                        </h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="codigoBarra"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/3 mt-5">
                        <h6>
                            Cantidad
                        </h6>
                        <vs-input class="inputx w-full  " v-model="cantidad" />
                    </div>
                    <div class="vx-col w-1/3 mt-5">
                        <h6>
                            Precio
                        </h6>
                        <vs-input class="inputx w-full  " v-model="precio" />
                    </div>

                    <div
                        class="vx-col w-full mt-5"
                        v-if="seleccionFechaVencimiento.id == 1"
                    >
                        <h6>Fecha Venciminento</h6>
                        <flat-pickr
                            :config="configTodateTimePicker"
                            v-model="fechaVencimiento"
                            @on-change="onFromChange"
                            class="w-full "
                        />
                    </div>

                    <br />
                    <div class="vx-col w-1/2 mt-5">
                        <vs-button
                            @click="limpiarCampos"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Limpiar Campos</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <vs-button
                            @click="AgregarArticuloDetalle"
                            color="success"
                            type="filled"
                            class="w-full"
                            >Agregar Articulo</vs-button
                        >
                    </div>
                </div>
                <br />

                <!-- Detalles Articulos -->
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <vx-card title="">
                        <div class="vx-row">
                            <vue-good-table
                                :columns="colDetalle"
                                :rows="listaDetalleRecepcion"
                                :pagination-options="{
                                    enabled: true,
                                    perPage: 10
                                }"
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
                                            content="Modificar Detalle"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="popModDetalle(props.row.id)"
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
                <!-- Calculos -->
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <vx-card title="">
                        <div class="vx-row">
                            <vue-good-table
                                class="w-full"
                                :columns="colTotal"
                                :rows="listaRecepcion"
                                :pagination-options="{
                                    enabled: true,
                                    perPage: 10
                                }"
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
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <vx-card title="">
                        <div class="vx-row">
                            <h6>Observaciones</h6>
                            <br /><br />
                            <quill-editor
                                class="w-full"
                                v-model="Observaciones"
                                :options="editorOption"
                            >
                                <div id="toolbar" slot="toolbar"></div>
                            </quill-editor>
                        </div>
                        <br /><br />
                    </vx-card>
                </div>
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/4 mt-5">
                                <vs-button
                                    @click="ActualizarListado"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Actualizar</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <vs-button
                                    @click="ImprimirDatos"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Imprimir</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <vs-button
                                    @click="volver"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <vs-button
                                    @click="CerrarRecepcion"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Cerrar Recepcion</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                </div>
            </vx-card>
            <div class="vx-row"></div>
        </div>
        <!-- Listado Articulos -->
        <vs-popup
            classContent="ListadoArticulos"
            title="Listado Articulos"
            :active.sync="popUpArticulos"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="">
                    <div class="vx-row">
                        <vx-card>
                            <vue-good-table
                                :columns="col"
                                :rows="listaArticulos"
                                :pagination-options="{
                                    enabled: true,
                                    perPage: 10
                                }"
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
                                            content="Agregar Articulo al listado"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                popAgregarArticulo(
                                                    props.row.NOMBRE,
                                                    props.row.UNIMEDBASE,
                                                    props.row.CODART_ONU,
                                                    props.row.CODART,
                                                    props.row.CODART_BARR,
                                                    props.row.idEstado,
                                                    props.row.UBICACION,
                                                    props.row.SECTOR,
                                                    props.row.idBodega,
                                                    props.row.idZona,
                                                    props.row.CANTXENB,
                                                    props.row.idACT_FECVEN,
                                                    props.row.idACTLOTE
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
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import "vue-good-table/dist/vue-good-table.css";
import { VueGoodTable } from "vue-good-table";
import { PlusCircleIcon } from "vue-feather-icons";
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
            popUpArticulos: false,
            codInternoRecepcion: 0,
            descripcionServicio: "",
            ndocumento: "",
            cantidad: 0,
            precio: 0,
            numint: 0,
            valorTotal: 0,
            fechaSistema: null,
            fechaRecepcion: null,
            fechaDocumento: null,
            fechaVencimiento: null,
            codigoBarra: "",
            Observaciones: "",
            nordencompra: "",
            nrib: "",
            codigoTrack: "",
            codigoOnu: "",
            codigoArticulo: "",
            nombre: "",
            idEstado: "",
            generico: "",
            categoriaFarmacia: "",
            concentracion: "",
            actFechaVencimiento: false,
            actLoteSerie: false,
            cantidadEmbalaje: "",
            idBodega: "",
            idZona: "",
            sector: "",
            ubicacion: "",
            unidadMedidaBase: "",
            descripcionProveedor: "",
            zgen: "",
            seleccionEstado: {
                id: 0,
                descripcionEstado: ""
            },
            seleccionBodega: {
                id: 0,
                descripcionBodega: ""
            },
            seleccionZona: {
                id: 0,
                descripcionZonas: ""
            },
            seleccionFechaVencimiento: {
                id: 0,
                descripcionFVen: "Seleccione Fecha Venciminento"
            },
            seleccionLoteSerie: {
                id: 0,
                descripcionLoteSerie: "Seleccione Lote/Serie"
            },
            seleccionProveedores: {
                id: 0,
                RUTPROV: "Ej. 22222222-2",
                NOMRAZSOC: ""
            },
            seleccionTipoDocumento: {
                id: 0,
                descripcionDocumento: ""
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
                    label: "Codigo Interno",
                    field: "CODART",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Especificacion Comprador",
                    field: "PRODUCTO",
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
                    label: "Unidad Medida",
                    field: "UNIMED",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Vencimiento Activo?",
                    field: "ACT_FECVEN",
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
                    label: "Cantidad Recepcionada",
                    field: "CANREC",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Cantidad Rechazada",
                    field: "CANRECH",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Cantidad Pendiente",
                    field: "PENDIENTE",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Precio Unitario",
                    field: "PREUNI",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Total Recepcionado",
                    field: "VALTOT",
                    filterOptions: {
                        enabled: true
                    }
                }
            ],
            col: [
                {
                    label: "Codigo de Barra",
                    field: "CODART_BARR",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Bodega",
                    field: "descripcionBodega",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Codigo Articulo",
                    field: "CODART",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Nombre Articulo",
                    field: "NOMBRE",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Unidad de Medida",
                    field: "UNIMEDBASE",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ],
            colTotal: [
                {
                    label: "NETO",
                    field: "NETO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Descuento",
                    field: "DCTO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Cargos",
                    field: "CARGO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Sub Total",
                    field: "SUBTOTAL",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "19% Iva",
                    field: "IVA",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Ajuste",
                    field: "AJUSTE",
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
            //Datos Listado
            rows: [],
            listaArticulos: [],
            listaDetalleRecepcion: [],
            listaRecepcion: [],
            listaEstado: [],
            listaBodega: [],
            listaTipoDocumento: [],
            listaZona: [],
            listadoProveedores: [],
            listaFVenciminento: [
                {
                    id: 1,
                    descripcionFVen: "Si"
                },
                {
                    id: 2,
                    descripcionFVen: "No"
                }
            ],
            listaFLoteSerie: [
                {
                    id: 1,
                    descripcionLoteSerie: "Si"
                },
                {
                    id: 2,
                    descripcionLoteSerie: "No"
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
        limpiarCampos() {
            try {
                this.cantidad = 0;
                this.precio = 0;
                this.codigoBarra = "";
                this.codigoOnu = "";
                this.codigoArticulo = "";
                this.nombre = "";
                this.seleccionEstado = {
                    id: 0,
                    descripcionEstado: ""
                };
                this.seleccionFechaVencimiento = {
                    id: 0,
                    descripcionFVen: "Seleccione Fecha Venciminento"
                };
                this.seleccionLoteSerie = {
                    id: 0,
                    descripcionLoteSerie: "Seleccione Lote/Serie"
                };
                this.cantidadEmbalaje = "";
                this.idBodega = 0;
                this.seleccionBodega = {
                    id: 0,
                    descripcionBodega: ""
                };
                this.idZona = 0;
                this.seleccionZona = {
                    id: 0,
                    descripcionZonas: ""
                };
                this.sector = "";
                this.ubicacion = "";
                this.unidadMedidaBase = "";
                this.idMod = 0;
            } catch (error) {
                console.log(error);
            }
        },
        setProveedor() {
            try {
                this.descripcionProveedor = "";
                this.descripcionProveedor = this.seleccionProveedores.NOMRAZSOC;
            } catch (error) {
                console.log(error);
            }
        },
        //Funciones Finales Recepcion
        ActualizarListado() {
            try {
                console.log("Ha ha");
            } catch (error) {
                console.log(error);
            }
        },
        ImprimirDatos() {
            try {
                console.log("Ha ha");
            } catch (error) {
                console.log(error);
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
        CerrarRecepcion() {
            try {
                console.log("Ha ha");
            } catch (error) {
                console.log(error);
            }
        },
        //PopUp
        popArticulos() {
            try {
                this.popUpArticulos = true;
            } catch (error) {
                console.log(error);
            }
        },
        popModDetalle(id) {
            try {
                console.log(id);
            } catch (error) {
                console.log(error);
            }
        },
        popAgregarArticulo(
            NOMBRE,
            UNIMEDBASE,
            CODART_ONU,
            CODART,
            CODART_BARR,
            idEstado,
            UBICACION,
            SECTOR,
            idBodega,
            idZona,
            CANTXENB,
            idACT_FECVEN,
            idACTLOTE
        ) {
            try {
                this.limpiarCampos();
                this.popUpCodInsumoEco = true;
                this.codigoBarra = CODART_BARR;
                this.codigoOnu = CODART_ONU;
                this.codigoArticulo = CODART;
                this.nombre = NOMBRE;
                let c = this.listaEstado;

                c.forEach((value, index) => {
                    if (idEstado == value.id) {
                        this.seleccionEstado.id = value.id;
                        this.seleccionEstado.descripcionEstado =
                            value.descripcionEstado;
                    }
                });

                c = [];
                if (idACT_FECVEN == 1) {
                    this.seleccionFechaVencimiento = {
                        id: 1,
                        descripcionFVen: "Si"
                    };
                } else {
                    this.seleccionFechaVencimiento = {
                        id: 2,
                        descripcionFVen: "No"
                    };

                    this.fechaVencimiento = null;
                }

                if (idACTLOTE == 1) {
                    this.seleccionLoteSerie = {
                        id: 1,
                        descripcionLoteSerie: "Si"
                    };
                } else {
                    this.seleccionLoteSerie = {
                        id: 2,
                        descripcionLoteSerie: "No"
                    };
                }

                this.cantidadEmbalaje = CANTXENB;
                this.idBodega = 0;

                c = this.listaBodega;

                c.forEach((value, index) => {
                    if (idBodega == value.id) {
                        this.seleccionBodega.id = value.id;
                        this.seleccionBodega.descripcionBodega =
                            value.descripcionBodega;
                    }
                });

                c = [];

                this.idZona = 0;

                c = this.listaZona;

                c.forEach((value, index) => {
                    if (idZona == value.id) {
                        this.seleccionZona.id = value.id;
                        this.seleccionZona.descripcionZonas =
                            value.descripcionZonas;
                    }
                });

                c = [];
                this.sector = SECTOR;
                this.ubicacion = UBICACION;

                this.unidadMedidaBase = UNIMEDBASE;
                this.popUpArticulos = false;
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD
        TraerArticulos() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetAllArticulos", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaArticulos = res.data;
                        if (this.listaArticulos.length < 0) {
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
        TraerDetalleRecepcion() {
            try {
                let data = {
                    NUMINT: this.$route.params.NUMINT
                };

                this.numint = this.$route.params.NUMINT;

                axios
                    .post(
                        this.localVal +
                            "/api/Mantenedor/GetArticulosIngresadosByCodInterno",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listaDetalleRecepcion = res.data;
                        if (this.listaDetalleRecepcion.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            let c = this.listaDetalleRecepcion;
                            let a = 0;
                            c.forEach((value, index) => {
                                a = a + parseInt(value.VALTOT);
                            });
                            this.valorTotal = a;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerRecepcion() {
            try {
                let data = {
                    NUMINT: this.$route.params.NUMINT
                };
                axios
                    .post(
                        this.localVal +
                            "/api/Mantenedor/GetRecepcionIngresadaByCodInterno",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listaRecepcion = res.data;
                        if (this.listaRecepcion.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            let c = this.listaRecepcion;
                            let idDoc = 0;
                            c.forEach((value, index) => {
                                this.fechaSistema = moment(value.FECSYS)
                                    .format("DD/MM/YYYY")
                                    .toString();
                                this.fechaRecepcion = moment(value.FECDES)
                                    .format("DD/MM/YYYY")
                                    .toString();
                                this.seleccionProveedores.RUTPROV =
                                    value.RUTPRO;
                                this.seleccionProveedores.NOMRAZSOC =
                                    value.NOMPRO;
                                this.descripcionProveedor = value.NOMPRO;
                                idDoc = value.TIPDOC;
                                this.ndocumento = value.NUMDOC;
                                this.fechaDocumento = moment(value.FECDOC)
                                    .format("DD/MM/YYYY")
                                    .toString();
                                this.nordencompra = value.NUMFAC;
                                this.nrib = value.NUMRIB;
                            });

                            c = [];

                            c = this.listaTipoDocumento;
                            c.forEach((value, index) => {
                                if (idDoc == value.id) {
                                    this.seleccionTipoDocumento.id;
                                    this.seleccionTipoDocumento.descripcionDocumento =
                                        value.descripcionDocumento;
                                }
                            });
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
                                `Bearer ` + sessionStorage.getItem("token")
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
        TraerTipoDocumentos() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetTipoDocumentos", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaTipoDocumento = res.data;
                        if (this.listaTipoDocumento.length < 0) {
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
        TraerEstado() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetAuthEstado", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaEstado = res.data;
                        if (this.listaEstado.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de Estado correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerBodega() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetBodega", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaBodega = res.data;
                        if (this.listaBodega.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de las Bodegas correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerZona() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetZona", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaZona = res.data;
                        if (this.listaZona.length < 0) {
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
        AgregarArticuloDetalle() {
            try {
                let total = this.precio * this.cantidad;
                let valorT = total + parseInt(this.valorTotal);
                let data = {
                    NUMINT: this.numint,
                    FECSYS: moment(this.fechaSistema, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    FECDES: moment(this.fechaRecepcion, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    RUTPRO: this.seleccionProveedores.RUTPROV,
                    NOMPRO: this.seleccionProveedores.NOMRAZSOC,
                    TIPDOC: this.seleccionTipoDocumento.id,
                    NUMDOC: this.ndocumento,
                    FECDOC: moment(this.fechaDocumento, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    NUMFAC: this.nordencompra,
                    NUMRIB: this.nrib,
                    CODART: this.codigoArticulo,
                    PRODUCTO: this.nombre,
                    CODBAR: this.codigoBarra,
                    UNIMED: this.unidadMedidaBase,
                    ACT_FECVEN: this.seleccionFechaVencimiento.id,
                    FECVEN: moment(this.fechaVencimiento, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    LOTE: this.seleccionLoteSerie.id,
                    CANREC: this.cantidad,
                    CANRECH: 0,
                    PENDIENTE: 0,
                    PREUNI: this.precio,
                    VALTOT: total,
                    DCTO: 0,
                    OBS: "",
                    CARGO: 0,
                    SUBTOTAL: valorT,
                    AJUSTE: 0
                };
                const dat = data;

                axios
                    .post(
                        this.localVal +
                            "/api/Mantenedor/PostArticuloDetalleCodInterno",
                        dat,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        const solicitudServer = res.data;
                        if (solicitudServer == true) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text:
                                    "Articulo Ingresado al detalle Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.TraerDetalleRecepcion();
                            this.TraerRecepcion();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible agregar el Articulo al detalle,intentelo nuevamente",
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
                this.fechaRecepcion = date.format("DD/MM/YYYY").toString();
                this.fechaSistema = date.format("DD/MM/YYYY").toString();
                this.fechaDocumento = date.format("DD/MM/YYYY").toString();
                this.fechaVencimiento = date.format("DD/MM/YYYY").toString();
            } catch (error) {
                console.log("No se cargo la ISO hora");
                console.log(error);
            }
        }
    },
    beforeMount() {
        this.TraerTipoDocumentos();
        this.TraerProveedores();
        this.TraerArticulos();
        this.TraerEstado();
        this.TraerBodega();
        this.TraerZona();
        setTimeout(() => {
            this.TraerDetalleRecepcion();
            this.TraerRecepcion();
        }, 2000);

        this.cargarHoras();
        this.openLoadingColor();
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1500px;
}
</style>
