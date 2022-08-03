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
                        <div class="vx-col w-1/2 mt-5">
                            <h6>Codigo Inicial</h6>
                            <vs-input
                                class="inputx w-full  "
                                v-model="codini"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>Codigo Final</h6>
                            <vs-input
                                class="inputx w-full  "
                                v-model="codter"
                            />
                        </div>
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
                    <div class="vx-row" v-if="consumomes">
                        <div class="vx-col w-1/4 mt-5">
                            <h6>Codigo Inicial</h6>
                            <vs-input
                                class="inputx w-full  "
                                v-model="codini"
                            />
                        </div>
                        <div class="vx-col w-1/4 mt-5">
                            <h6>Codigo Final</h6>
                            <vs-input
                                class="inputx w-full  "
                                v-model="codter"
                            />
                        </div>
                        <div class="vx-col w-1/4 mt-5">
                            <h6>Seleccione Mes</h6>
                            <v-select
                                v-model="seleccionMes"
                                placeholder="Ej. Junio"
                                class="w-full select-large"
                                label="descripcionMes"
                                :options="listadoMes"
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/4 mt-5">
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
                    <div class="vx-row" v-if="consumomesservicio">
                        <div class="vx-col w-1/5 mt-5">
                            <h6>Codigo Inicial</h6>
                            <vs-input
                                class="inputx w-full  "
                                v-model="codini"
                            />
                        </div>
                        <div class="vx-col w-1/5 mt-5">
                            <h6>Codigo Final</h6>
                            <vs-input
                                class="inputx w-full  "
                                v-model="codter"
                            />
                        </div>
                        <div class="vx-col w-1/5 mt-5">
                            <h6>Seleccione Mes</h6>
                            <v-select
                                v-model="seleccionMes"
                                placeholder="Ej. Junio"
                                class="w-full select-large"
                                label="descripcionMes"
                                :options="listadoMes"
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/5 mt-5">
                            <h6>Seleccione Servicio</h6>
                            <v-select
                                v-model="seleccionServicios"
                                placeholder="Ej. INFORMATICA"
                                class="w-full select-large"
                                label="descripcionServicio"
                                :options="listadoServicios"
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/5 mt-5">
                            <h6>.</h6>
                            <vs-button
                                @click="GetConsumoMesServicio"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Buscar</vs-button
                            >
                        </div>
                    </div>
                    <div class="vx-row" v-if="fechavencimiento">
                        <div class="vx-col w-1/3 mt-5">
                            <h6>Codigo Inicial</h6>
                            <vs-input
                                class="inputx w-full  "
                                v-model="codini"
                            />
                        </div>
                        <div class="vx-col w-1/3 mt-5">
                            <h6>Codigo Final</h6>
                            <vs-input
                                class="inputx w-full  "
                                v-model="codter"
                            />
                        </div>
                        <div class="vx-col w-1/3 mt-5">
                            <h6>.</h6>
                            <vs-button
                                @click="GetFechaVencimiento"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Buscar</vs-button
                            >
                        </div>
                    </div>
                    <div class="vx-row" v-if="zgen">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>Seleccione Mes</h6>
                            <v-select
                                v-model="seleccionMes"
                                placeholder="Ej. Junio"
                                class="w-full select-large"
                                label="descripcionMes"
                                :options="listadoMes"
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>.</h6>
                            <vs-button
                                @click="GetZGen"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Buscar</vs-button
                            >
                        </div>
                    </div>
                    <br />
                    <div class="vx-row" v-if="zgenpriorizado">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>Seleccione Mes</h6>
                            <v-select
                                v-model="seleccionMes"
                                placeholder="Ej. Junio"
                                class="w-full select-large"
                                label="descripcionMes"
                                :options="listadoMes"
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>.</h6>
                            <vs-button
                                @click="GetZGenPriozados"
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
                                            content="Ver Bincard"
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
            consumomesservicio: false,
            fechavencimiento: false,
            zgen: false,
            zgenpriorizado: false,
            popUpBincard: false,
            fechaInicio: null,
            fechaTermino: null,
            codini: "",
            codter: "",
            idMod: 0,
            seleccionReporte: {
                id: 0,
                descripcionReporte: "Ej. Bincard"
            },
            seleccionMes: {
                id: 0,
                descripcionMes: "Seleccione Mes"
            },
            seleccionServicios: {
                id: 0,
                descripcionServicio: "Seleccione Servicio"
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
            listadoServicios: [],
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
                },
                {
                    id: 5,
                    descripcionReporte: "Consumo por Mes"
                },
                {
                    id: 6,
                    descripcionReporte: "Consumo por Mes/Servicio"
                },
                {
                    id: 7,
                    descripcionReporte: "Fecha Vencimiento/Cenabast"
                },
                {
                    id: 8,
                    descripcionReporte: "ZGEN"
                },
                {
                    id: 9,
                    descripcionReporte: "ZGEN Priorizados"
                }
            ],
            listadoMes: [
                {
                    id: 1,
                    descripcionMes: "Enero"
                },
                {
                    id: 2,
                    descripcionMes: "Febrero"
                },
                {
                    id: 3,
                    descripcionMes: "Marzo"
                },
                {
                    id: 4,
                    descripcionMes: "Abril"
                },
                {
                    id: 5,
                    descripcionMes: "Mayo"
                },
                {
                    id: 6,
                    descripcionMes: "Junio"
                },
                {
                    id: 7,
                    descripcionMes: "Julio"
                },
                {
                    id: 8,
                    descripcionMes: "Agosto"
                },
                {
                    id: 9,
                    descripcionMes: "Septiembre"
                },
                {
                    id: 10,
                    descripcionMes: "Octubre"
                },
                {
                    id: 11,
                    descripcionMes: "Noviembre"
                },
                {
                    id: 12,
                    descripcionMes: "Diciembre"
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
                this.consumomes = false;
                this.fechaInicio = null;
                this.fechaTermino = null;
                this.codini = "";
                this.codter = "";
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
                    this.consumomes = false;
                    this.GetSaldoArticulos();
                } else if (this.seleccionReporte.id == 4) {
                    this.listaActive = false;
                    this.consumoanio = true;
                    this.consumomes = false;
                    this.consumomesservicio = false;
                    this.fechavencimiento = false;
                    this.zgen = false;
                    this.zgenpriorizado = false;
                } else if (this.seleccionReporte.id == 5) {
                    this.listaActive = false;
                    this.consumoanio = false;
                    this.consumomes = true;
                    this.consumomesservicio = false;
                    this.fechavencimiento = false;
                    this.zgen = false;
                    this.zgenpriorizado = false;
                } else if (this.seleccionReporte.id == 6) {
                    this.listaActive = false;
                    this.consumoanio = false;
                    this.consumomes = false;
                    this.consumomesservicio = true;
                    this.fechavencimiento = false;
                    this.zgen = false;
                    this.zgenpriorizado = false;
                } else if (this.seleccionReporte.id == 7) {
                    this.listaActive = false;
                    this.consumoanio = false;
                    this.consumomes = false;
                    this.consumomesservicio = false;
                    this.fechavencimiento = true;
                    this.zgen = false;
                    this.zgenpriorizado = false;
                } else if (this.seleccionReporte.id == 8) {
                    this.listaActive = false;
                    this.consumoanio = false;
                    this.consumomes = false;
                    this.consumomesservicio = false;
                    this.fechavencimiento = false;
                    this.zgen = true;
                    this.zgenpriorizado = false;
                } else if (this.seleccionReporte.id == 9) {
                    this.listaActive = false;
                    this.consumoanio = false;
                    this.consumomes = false;
                    this.consumomesservicio = false;
                    this.fechavencimiento = false;
                    this.zgen = false;
                    this.zgenpriorizado = true;
                }
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD
        TraerServicio() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetServicios", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listadoServicios = res.data;
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
                    CODINI: this.codini,
                    CODTER: this.codter
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
                let mes = "";
                if (this.seleccionMes.id > 0 && this.seleccionMes.id < 10) {
                    mes = "0" + this.seleccionMes.id;
                } else {
                    mes = this.seleccionMes.id;
                }
                let data = {
                    CODINI: this.codini,
                    CODTER: this.codter,
                    MES: mes
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
        GetConsumoMesServicio() {
            try {
                let mes = "";
                if (this.seleccionMes.id > 0 && this.seleccionMes.id < 10) {
                    mes = "0" + this.seleccionMes.id;
                } else {
                    mes = this.seleccionMes.id;
                }
                let data = {
                    CODINI: this.codini,
                    CODTER: this.codter,
                    MES: mes,
                    idServicio: this.seleccionServicios.id
                };
                if (
                    this.seleccionMes.id == 0 &&
                    this.seleccionServicios.id == 0
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "Debe seleccionar el mes o el servicio para continuar",
                        color: "danger",
                        position: "top-right"
                    });
                }
                axios
                    .post(
                        this.localVal + "/api/Reportes/GetConsumoMesServicio",
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
                                    label: "Mes",
                                    field: "MES",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Servicio",
                                    field: "descripcionServicio",
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
        GetZGen() {
            try {
                let mes = "";
                if (this.seleccionMes.id > 0 && this.seleccionMes.id < 10) {
                    mes = "0" + this.seleccionMes.id;
                } else {
                    mes = this.seleccionMes.id;
                }
                let data = {
                    MES: mes
                };
                if (this.seleccionMes.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar el mes para continuar",
                        color: "danger",
                        position: "top-right"
                    });
                }
                axios
                    .post(this.localVal + "/api/Reportes/GetZGEN", data, {
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
                                    label: "Codigo DEIS Servicio de Salud",
                                    field: "CDEISSV",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Codigo DEIS establecimiento",
                                    field: "DEISEST",
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
                                    label: "Codigo Interno",
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
                                    label:
                                        "Medicamento Corresponde al Arsenal del Establecimiento",
                                    field: "VALMED",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Mes de Recepcion del Medicamento",
                                    field: "MES",
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
                                    label: "Precio Unitario",
                                    field: "PRECIO",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Precio Total",
                                    field: "TOTAL",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Unidad de Medida",
                                    field: "UNIMED",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label:
                                        "Mes de Salida de Medicamento a Farmacia Central",
                                    field: "MESSAL",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Cantidad de Salida a Farmacia",
                                    field: "DESPACHO",
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
        GetZGenPriozados() {
            try {
                let mes = "";
                if (this.seleccionMes.id > 0 && this.seleccionMes.id < 10) {
                    mes = "0" + this.seleccionMes.id;
                } else {
                    mes = this.seleccionMes.id;
                }
                let data = {
                    MES: mes
                };
                if (this.seleccionMes.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar el mes para continuar",
                        color: "danger",
                        position: "top-right"
                    });
                }
                axios
                    .post(
                        this.localVal + "/api/Reportes/GetZGENPriorizados",
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
                                    label: "Via Adquisicion",
                                    field: "NUMORD",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Codigo DEIS Servicio de Salud",
                                    field: "CDEISSV",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Codigo DEIS establecimiento",
                                    field: "DEISEST",
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
                                    label: "Codigo Interno",
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
                                    label:
                                        "Medicamento Corresponde al Arsenal del Establecimiento",
                                    field: "VALMED",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Mes de Recepcion del Medicamento",
                                    field: "MES",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Cantidad Recepcionada",
                                    field: "STOCKFISICO",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Precio Unitario",
                                    field: "STOCKBINSAL",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Cantidad Recepcionada Por Compra",
                                    field: "CANREC",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label:
                                        "Cantidad ingresada por concepto de devolucion de prestamo de otro establecimiento",
                                    field: "CANDEL",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label:
                                        "Cantidad ingresada por prestamo de otro establecimiento",
                                    field: "CANPRES",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label:
                                        "Cantidad total dispensada a pacientes",
                                    field: "CANPAC",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label:
                                        "Cantidad Prestada o devuelta a otro establecimiento",
                                    field: "CANPOE",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Unidades Mermadas",
                                    field: "UMERMA",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Monto Mermado",
                                    field: "MONMERMA",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Stock Final Físico",
                                    field: "SALDO",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label:
                                        "Stock Final en Sistema de Inventario",
                                    field: "SALDOBIN",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Precio Unitario (PPP) de stock",
                                    field: "PRECIO1",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Precio 1",
                                    field: "PRECIO2",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Precio 2",
                                    field: "PRECIO3",
                                    filterOptions: {
                                        enabled: true
                                    }
                                },
                                {
                                    label: "Precio 3",
                                    field: "PRECIO4",
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
        GetFechaVencimiento() {
            try {
                if (
                    this.codini == null &&
                    this.codini == "" &&
                    this.codter == null &&
                    this.codter == ""
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "Debe Ingresar el codigo inicial y de termino para realizar la busqueda",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        CODINI: this.codini,
                        CODTER: this.codter
                    };

                    axios
                        .post(
                            this.localVal + "/api/Reportes/GetFechaVencimiento",
                            data,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
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
                                        label: "Nombre",
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
                                        field: "FECVEN",
                                        filterOptions: {
                                            enabled: true
                                        }
                                    },
                                    {
                                        label: "Dias de Vencimiento",
                                        field: "DIASVENCIMIENTO",
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
                                        label: "Codigo de Barra",
                                        field: "CODBAR",
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
                                        label: "Folio",
                                        field: "FOLIO",
                                        filterOptions: {
                                            enabled: true
                                        }
                                    },
                                    {
                                        label: "Fecha Recepcion",
                                        field: "FRECEP",
                                        filterOptions: {
                                            enabled: true
                                        }
                                    },
                                    {
                                        label: "Nombre Proveedor",
                                        field: "NOMPROV",
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
                                        label: "Numero Documento",
                                        field: "NUMDOC",
                                        filterOptions: {
                                            enabled: true
                                        }
                                    },
                                    {
                                        label: "Dias Recepcionado",
                                        field: "DIASREC",
                                        filterOptions: {
                                            enabled: true
                                        }
                                    },
                                    {
                                        label: "Ordenes de Compra",
                                        field: "ORDENCOMPRA",
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
                }
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
            this.TraerServicio();
        }, 2000);
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1800px;
}
</style>
