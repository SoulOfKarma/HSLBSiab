<template>
    <div>
        <div class="vx-col md:w-1/1 w-full mb-base">
            <vx-card title="Reportes">
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <div class="vx-col w-full mt-5">
                        <h6>Seleccione Reporte</h6>
                        <br />
                        <v-select
                            taggable
                            v-model="seleccionReporte"
                            placeholder="Ej. Bincard"
                            class="w-full select-large"
                            label="descripcionReporte"
                            :options="listadoReportes"
                            @input="GetReporteEspecifico"
                        ></v-select>
                    </div>
                    <br />
                    <div class="vx-row" v-if="consumoanio">
                        <div class="vx-col w-1/3 mt-5">
                            <h6>Fecha Inicio</h6>
                            <flat-pickr
                                :config="configFromdateTimePicker"
                                v-model="fechaInicio"
                                placeholder="Fecha Inicio"
                                @on-change="onFromChange"
                                class="w-full "
                            />
                        </div>
                        <div class="vx-col w-1/3 mt-5">
                            <h6>Fecha Termino</h6>
                            <flat-pickr
                                :config="configTodateTimePicker"
                                v-model="fechaTermino"
                                placeholder="Fecha Termino"
                                @on-change="onToChange"
                                class="w-full "
                            />
                        </div>
                        <div class="vx-col w-1/3 mt-5">
                            <h6>.</h6>
                            <vs-button
                                @click="GetConsumoAnio"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Buscar</vs-button
                            >
                        </div>
                    </div>
                    <br />
                    <div class="vx-row" v-if="consumomes">
                        <div class="vx-col w-1/3 mt-5">
                            <h6>Fecha Inicio</h6>
                            <flat-pickr
                                :config="configFromdateTimePicker"
                                v-model="fechaInicio"
                                placeholder="Fecha Inicio"
                                @on-change="onFromChange"
                                class="w-full "
                            />
                        </div>
                        <div class="vx-col w-1/3 mt-5">
                            <h6>Fecha Termino</h6>
                            <flat-pickr
                                :config="configTodateTimePicker"
                                v-model="fechaTermino"
                                placeholder="Fecha Termino"
                                @on-change="onToChange"
                                class="w-full "
                            />
                        </div>
                        <div class="vx-col w-1/3 mt-5">
                            <h6>.</h6>
                            <vs-button
                                @click="GetConsumoMes"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Buscar</vs-button
                            >
                        </div>
                    </div>
                    <br />
                    <vx-card title="">
                        <div class="vx-row">
                            <vue-good-table
                                v-if="listaActive"
                                class="w-full"
                                :columns="column"
                                :rows="listadoGeneral"
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
                                                GetBincard(props.row.CODART)
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
            </vx-card>
            <div class="vx-row"></div>
        </div>
        <vs-popup
            classContent="Bincard"
            title="Bincard"
            :active.sync="popUpBincard"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="">
                    <div class="vx-row">
                        <vue-good-table
                            :columns="columnBincard"
                            :rows="listaBincard"
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
                                    {{ props.formattedRow[props.column.field] }}
                                </span>
                            </template>
                        </vue-good-table>
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
            localDoc: process.env.MIX_APP_URL_DOCUMENTOS,
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
            listaActive: false,
            consumoanio: false,
            consumomes: false,
            popUpBincard: false,
            fechaInicio: null,
            fechaTermino: null,
            idMod: 0,
            seleccionReporte: {
                id: 0,
                descripcionReporte: "Ej. Bincard"
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
                minDate: "today",
                maxDate: null,
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
            column: [],
            columnBincard: [
                {
                    label: "Tipo",
                    field: "TIPO",
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
                    label: "Fecha",
                    field: "FECHA",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Folio Recepcion",
                    field: "FOLREC",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Orden de Compra",
                    field: "NUMORD",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Proveedor",
                    field: "PROVEEDOR",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Folio Despacho",
                    field: "FOLDES",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Servicio",
                    field: "SERVICIO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Codigo Interno",
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
                    label: "Precio",
                    field: "PRECIO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Cantidad",
                    field: "CANTIDAD",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Saldo",
                    field: "SALDO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Motivo Anulacion",
                    field: "NOMMOT",
                    filterOptions: {
                        enabled: true
                    }
                }
            ],
            //Datos Listado
            rows: [],
            listadoGeneral: [],
            listaBincard: [],
            listadoReportes: [
                {
                    id: 1,
                    descripcionReporte: "Saldo Productos"
                },
                {
                    id: 2,
                    descripcionReporte: "Saldo Valorizado"
                },
                {
                    id: 3,
                    descripcionReporte: "Saldo Bincard"
                },
                {
                    id: 4,
                    descripcionReporte: "Consumo por Año"
                }
            ]
        };
    },
    methods: {
        //Metodos Reusables
        onFromChange(selectedDates, dateStr, instance) {
            this.$set(this.configTodateTimePicker, "minDate", dateStr);
        },
        onToChange(selectedDates, dateStr, instance) {
            this.$set(this.configFromdateTimePicker, "maxDate", dateStr);
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
        GetReporteEspecifico() {
            try {
                this.listaActive = true;
                this.consumoanio = false;
                if (this.seleccionReporte.id == 1) {
                    this.column = [
                        {
                            label: "Codigo Interno",
                            field: "CODART",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "Codigo ZGEN",
                            field: "ZGEN",
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
                            label: "Saldo",
                            field: "saldoCorrecto",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "Opciones",
                            field: "action"
                        }
                    ];
                    this.consumoanio = false;
                    this.GetSaldos();
                } else if (this.seleccionReporte.id == 2) {
                    this.column = [
                        {
                            label: "Codigo Interno",
                            field: "CODART",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "Codigo ZGEN",
                            field: "ZGEN",
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
                            label: "Saldo",
                            field: "saldoCorrecto",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "Ultimo Precio",
                            field: "ULTPRE",
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
                        },
                        {
                            label: "Opciones",
                            field: "action"
                        }
                    ];
                    this.consumoanio = false;
                    this.GetSaldoValorizado();
                } else if (this.seleccionReporte.id == 3) {
                    this.column = [
                        {
                            label: "Codigo Interno",
                            field: "CODART",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "Codigo ZGEN",
                            field: "ZGEN",
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
                            label: "Saldo",
                            field: "saldoCorrecto",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "Estado",
                            field: "Estado",
                            filterOptions: {
                                enabled: true
                            }
                        },
                        {
                            label: "Opciones",
                            field: "action"
                        }
                    ];
                    this.consumoanio = false;
                    this.GetSaldoArticulos();
                } else if (this.seleccionReporte.id == 4) {
                    this.listaActive = false;
                    this.consumoanio = true;
                } else if (this.seleccionReporte.id == 5) {
                    this.listaActive = false;
                    this.consumoanio = false;
                    this.consumomes = true;
                }
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD
        GetSaldoArticulos() {
            try {
                axios
                    .get(
                        this.localVal + "/api/Reportes/GetArticulosSaldoEstado",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoGeneral = res.data;
                        if (this.listadoGeneral.length < 0) {
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
        GetConsumoAnio() {
            try {
                let data = {
                    FECINI: moment(this.fechaInicio, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    FECTER: moment(this.fechaTermino, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    ANIO: moment(this.fechaInicio, "DD-MM-YYYY").format("YYYY"),
                    MES: moment(this.fechaInicio, "DD-MM-YYYY").format("MM")
                };
                axios
                    .post(
                        this.localVal + "/api/Reportes/GetConsumoAnio",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoGeneral = res.data;
                        if (this.listadoGeneral.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            this.column = [
                                {
                                    label: "Codigo Interno",
                                    field: "CODART",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Codigo ZGEN",
                                    field: "ZGEN",
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
                                    label: "Consumo",
                                    field: "CONSUMO",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Opciones",
                                    field: "action"
                                }
                            ];
                            this.listaActive = true;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        GetConsumoMes() {
            try {
                let data = {
                    FECINI: moment(this.fechaInicio, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    FECTER: moment(this.fechaTermino, "DD-MM-YYYY").format(
                        "YYYY-MM-DD"
                    ),
                    ANIO: moment(this.fechaInicio, "DD-MM-YYYY").format("YYYY"),
                    MES: moment(this.fechaInicio, "DD-MM-YYYY").format("MM")
                };
                axios
                    .post(this.localVal + "/api/Reportes/GetConsumoMes", data, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listadoGeneral = res.data;
                        if (this.listadoGeneral.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            this.column = [
                                {
                                    label: "Año",
                                    field: "ANIO",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Codigo Interno",
                                    field: "CODART",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Codigo ZGEN",
                                    field: "ZGEN",
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
                                    label: "Mes",
                                    field: "MES",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Consumo",
                                    field: "CONSUMO",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Opciones",
                                    field: "action"
                                }
                            ];
                            this.listaActive = true;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        GetBincard(codart) {
            try {
                let data = {
                    CODART: codart
                };
                axios
                    .post(this.localVal + "/api/Reportes/GetBincard", data, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        let saldo = 0;
                        let c = res.data;
                        if (c.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            let d = [];
                            c.forEach((value, index) => {
                                let data = {
                                    TIPO: "",
                                    NOMBRE: "",
                                    FECHA: "",
                                    FOLDES: "",
                                    FOLREC: "",
                                    NUMORD: "",
                                    PROVEEDOR: "",
                                    CODART: "",
                                    CODBAR: "",
                                    PRECIO: "",
                                    CANTIDAD: "",
                                    SERVICIO: "",
                                    SALDO: "",
                                    NOMMOT: ""
                                };
                                if (value.TIPO == "Saldo Inventario") {
                                    saldo =
                                        parseInt(saldo) +
                                        parseInt(value.CANTIDAD);
                                } else if (
                                    value.TIPO == "Recepcion" &&
                                    value.NOMMOT == "-"
                                ) {
                                    saldo =
                                        parseInt(saldo) +
                                        parseInt(value.CANTIDAD);
                                } else if (
                                    value.TIPO == "Recepcion" &&
                                    value.NOMMOT != "-"
                                ) {
                                } else if (
                                    value.TIPO == "Despacho" &&
                                    value.NOMMOT == "-"
                                ) {
                                    saldo =
                                        parseInt(saldo) -
                                        parseInt(value.CANTIDAD);
                                } else if (
                                    value.TIPO == "Despacho" &&
                                    value.NOMMOT != "-"
                                ) {
                                }

                                data.TIPO = value.TIPO;
                                data.NOMBRE = value.NOMBRE;
                                data.FECHA = value.FECHA;
                                data.FOLDES = value.FOLDES;
                                data.FOLREC = value.FOLREC;
                                data.NUMORD = value.NUMORD;
                                data.PROVEEDOR = value.PROVEEDOR;
                                data.CODART = value.CODART;
                                data.CODBAR = value.CODBAR;
                                data.PRECIO = value.PRECIO;
                                data.CANTIDAD = value.CANTIDAD;
                                data.SERVICIO = value.SERVICIO;
                                data.SALDO = saldo;
                                data.NOMMOT = value.NOMMOT;
                                d.push(data);
                            });
                            this.listaBincard = d;
                            this.popUpBincard = true;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        GetSaldos() {
            try {
                axios
                    .get(this.localVal + "/api/Reportes/GetSaldosReporte", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listadoGeneral = res.data;
                        if (this.listadoGeneral.length < 0) {
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
        GetSaldoValorizado() {
            try {
                axios
                    .get(
                        this.localVal +
                            "/api/Reportes/GetSaldosValorizadoReporte",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadoGeneral = res.data;
                        if (this.listadoGeneral.length < 0) {
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
                    token: sessionStorage.getItem("token")
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
                            window.sessionStorage.clear();
                            window.localStorage.clear();
                            router.push("/pages/login");
                        } else {
                            sessionStorage.setItem("token", tok);
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
            //this.GetSaldoArticulos();
        }, 2000);
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1800px;
}
</style>
