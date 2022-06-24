<template>
    <div>
        <vx-card title="Medicamentos">
            <div>
                <vs-button color="primary" type="filled" @click="popMedicamento"
                    >Agregar Medicamento</vs-button
                >
            </div>
            <br />
            <div>
                <vx-card>
                    <vue-good-table
                        :columns="columns"
                        :rows="rows"
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
                            <span v-else-if="props.column.field === 'action'">
                                <plus-circle-icon
                                    content="Modificar Servicio"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popModificarMedicamento(
                                            props.row.id,
                                            props.row.CODART_TRACK,
                                            props.row.NOMBRE,
                                            props.row.GENERICO,
                                            props.row.CAT_FARMACIA,
                                            props.row.UNIMEDBASE,
                                            props.row.CONCENTRACION,
                                            props.row.CODART_ONU,
                                            props.row.CODART,
                                            props.row.CODART_BARR,
                                            props.row.UBICACION,
                                            props.row.SECTOR,
                                            props.row.ZGEN,
                                            props.row.idBodega,
                                            props.row.idZona,
                                            props.row.idEstado,
                                            props.row.LABORATORIO,
                                            props.row.CANTXENB,
                                            props.row.idACT_FECVEN,
                                            props.row.idACTLOTE
                                        )
                                    "
                                ></plus-circle-icon>
                                <plus-circle-icon
                                    content="Agregar Codigo Nuevo"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popAgregarCodMedicamento(
                                            props.row.CODART_TRACK,
                                            props.row.NOMBRE,
                                            props.row.GENERICO,
                                            props.row.CAT_FARMACIA,
                                            props.row.UNIMEDBASE,
                                            props.row.CONCENTRACION,
                                            props.row.CODART_ONU,
                                            props.row.CODART,
                                            props.row.CODART_BARR,
                                            props.row.UBICACION,
                                            props.row.SECTOR,
                                            props.row.ZGEN,
                                            props.row.idBodega,
                                            props.row.idZona,
                                            props.row.idEstado,
                                            props.row.LABORATORIO,
                                            props.row.CANTXENB,
                                            props.row.idACT_FECVEN,
                                            props.row.idACTLOTE
                                        )
                                    "
                                ></plus-circle-icon>
                            </span>
                            <!-- Column: Common -->
                            <span v-else>
                                {{ props.formattedRow[props.column.field] }}
                            </span>
                        </template>
                    </vue-good-table>
                </vx-card>
            </div>
            <vs-popup
                classContent="AgregarMedicamento"
                title="Agregar Medicamento"
                :active.sync="popUpMedicamento"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Codigo de Barra
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codigoBarra"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Codigo Track</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codigoTrack"
                                />
                            </div>
                        </div>
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Codigo Onu</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codigoOnu"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Codigo Interno</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codigoArticulo"
                                />
                            </div>
                        </div>
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Nombre Articulo</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="nombre"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Generico</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="generico"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Categoria Farmacia</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="categoriaFarmacia"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Unidad Medida Base</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="unidadMedidaBase"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Concentracion</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="concentracion"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Estado</h6>

                                <v-select
                                    v-model="seleccionEstado"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionEstado"
                                    :options="listaEstado"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Activacion Fecha Venciminento</h6>

                                <v-select
                                    v-model="seleccionFechaVenciminento"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionFVen"
                                    :options="listaFVenciminento"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Activacion Lote/Serie</h6>

                                <v-select
                                    v-model="seleccionLoteSerie"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionLoteSerie"
                                    :options="listaFLoteSerie"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Laboratorio</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="laboratorio"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Cantidad Embalaje</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="cantidadEmbalaje"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Bodega</h6>

                                <v-select
                                    v-model="seleccionBodega"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionBodega"
                                    :options="listaBodega"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Zona</h6>

                                <v-select
                                    v-model="seleccionZona"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionZonas"
                                    :options="listaZona"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Sector</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="sector"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Ubicacion</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="ubicacion"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Z Gen</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="zgen"
                                />
                            </div>
                        </div>
                        <br />
                        <div class="vx-row w-full">
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="popUpMedicamento = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="AgregarMedicamento"
                                    color="success"
                                    type="filled"
                                    class="w-full"
                                    >Agregar Medicamento</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <!-- Modificar Medicamentos -->
            <vs-popup
                classContent="ModificarMedicamento"
                title="Modificar Medicamento"
                :active.sync="popUpMedicamentoMod"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Codigo de Barra
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codigoBarra"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Codigo Track</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codigoTrack"
                                />
                            </div>
                        </div>
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Codigo Onu</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codigoOnu"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Codigo Interno</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codigoArticulo"
                                />
                            </div>
                        </div>
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Nombre Articulo</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="nombre"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Generico</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="generico"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Categoria Farmacia</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="categoriaFarmacia"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Unidad Medida Base</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="unidadMedidaBase"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Concentracion</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="concentracion"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Estado</h6>

                                <v-select
                                    v-model="seleccionEstado"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionEstado"
                                    :options="listaEstado"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Activacion Fecha Venciminento</h6>

                                <v-select
                                    v-model="seleccionFechaVenciminento"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionFVen"
                                    :options="listaFVenciminento"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Activacion Lote/Serie</h6>

                                <v-select
                                    v-model="seleccionLoteSerie"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionLoteSerie"
                                    :options="listaFLoteSerie"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Laboratorio</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="laboratorio"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Cantidad Embalaje</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="cantidadEmbalaje"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Bodega</h6>

                                <v-select
                                    v-model="seleccionBodega"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionBodega"
                                    :options="listaBodega"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Zona</h6>

                                <v-select
                                    v-model="seleccionZona"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionZonas"
                                    :options="listaZona"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Sector</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="sector"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Ubicacion</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="ubicacion"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Z Gen</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="zgen"
                                />
                            </div>
                        </div>
                        <br />
                        <div class="vx-row w-full md-5">
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="popUpMedicamentoMod = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="ModificarMedicamento"
                                    color="warning"
                                    type="filled"
                                    class="w-full m-1"
                                    >Modificar Medicamento</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <!-- Codigo Medicamento -->
            <vs-popup
                classContent="AgregarCodigoNMedicamento"
                title="Agregar Nuevo Codigo a Medicamento"
                :active.sync="popUpNCMedicamento"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/4 mt-5">
                                <h6>Bodega</h6>

                                <v-select
                                    v-model="seleccionBodega"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionBodega"
                                    :options="listaBodega"
                                    disabled
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <h6>Nombre Articulo</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="nombre"
                                    disabled
                                />
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <h6>Codigo Interno</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codigoArticulo"
                                    disabled
                                />
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <h6>Unidad Medida Base</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="unidadMedidaBase"
                                    disabled
                                />
                            </div>
                        </div>
                        <br />
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Codigo de Barra
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codigoBarra"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Agregar
                                </h6>
                                <vs-button
                                    @click="ValidarCodigoBarra"
                                    color="success"
                                    type="filled"
                                    class="w-full"
                                    >Agregar Codigo Medicamento</vs-button
                                >
                            </div>
                        </div>
                        <div class="vx-row">
                            <vx-card>
                                <vue-good-table
                                    :columns="col"
                                    :rows="listaCodNuevo"
                                    :pagination-options="{
                                        enabled: true,
                                        perPage: 10
                                    }"
                                >
                                    <template
                                        slot="table-row"
                                        slot-scope="props"
                                    >
                                        <!-- Column: Name -->
                                        <span
                                            v-if="
                                                props.column.field ===
                                                    'fullName'
                                            "
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
                            </vx-card>
                        </div>
                        <br />
                        <div class="vx-row w-full md-5">
                            <div class="vx-col w-full ">
                                <vs-button
                                    @click="popUpNCMedicamento = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
        </vx-card>
    </div>
</template>
<script>
import axios from "axios";
import router from "@/router";
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
        PlusCircleIcon
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
            popUpMedicamento: false,
            popUpMedicamentoMod: false,
            popUpNCMedicamento: false,
            descripcionServicio: "",
            codigoBarra: "",
            codigoTrack: "",
            codigoOnu: "",
            codigoArticulo: "",
            nombre: "",
            generico: "",
            categoriaFarmacia: "",
            unidadMedidaBase: "",
            concentracion: "",
            idEstado: "",
            actFechaVencimiento: false,
            actLoteSerie: false,
            laboratorio: "",
            cantidadEmbalaje: "",
            idBodega: "",
            idZona: "",
            sector: "",
            ubicacion: "",
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
            seleccionFechaVenciminento: {
                id: 0,
                descripcionFVen: "Seleccione Fecha Venciminento"
            },
            seleccionLoteSerie: {
                id: 0,
                descripcionLoteSerie: "Seleccione Lote/Serie"
            },
            idMod: 0,
            columns: [
                {
                    label: "Codigo de Barra",
                    field: "CODART_BARR",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Codigo de Barra 2",
                    field: "CODBAR2",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Codigo Track",
                    field: "CODART_TRACK",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Codigo Onu",
                    field: "CODART_ONU",
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
                    label: "Nombre Medicamento",
                    field: "NOMBRE",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Generico",
                    field: "GENERICO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Categoria Farmacia",
                    field: "CAT_FARMACIA",
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
                    label: "Concentracion",
                    field: "CONCENTRACION",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Laboratorio",
                    field: "LABORATORIO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Estado",
                    field: "descripcionEstado",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Opciones",
                    field: "action"
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
                    label: "Codigo Articulo",
                    field: "CODART",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Nombre Medicamento",
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
                    label: "Concentracion",
                    field: "CONCENTRACION",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Laboratorio",
                    field: "LABORATORIO",
                    filterOptions: {
                        enabled: true
                    }
                }
            ],
            //Datos Listado
            rows: [],
            listaCodNuevo: [],
            listaEstado: [],
            listaBodega: [],
            listaZona: [],
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
                this.codigoBarra = "";
                this.codigoTrack = "";
                this.codigoOnu = "";
                this.codigoArticulo = "";
                this.nombre = "";
                this.generico = "";
                this.categoriaFarmacia = "";
                this.unidadMedidaBase = "";
                this.concentracion = "";
                this.seleccionEstado = { id: 0, descripcionEstado: "" };
                this.laboratorio = "";
                this.cantidadEmbalaje = "";
                this.idBodega = 0;
                this.seleccionBodega = { id: 0, descripcionBodega: "" };
                this.idZona = 0;
                this.seleccionZona = { id: 0, descripcionZonas: "" };
                this.seleccionFechaVenciminento = {
                    id: 0,
                    descripcionFVen: ""
                };
                this.seleccionLoteSerie = { id: 0, descripcionLoteSerie: "" };
                this.sector = "";
                this.ubicacion = "";
                this.zgen = "";
                this.idMod = 0;
            } catch (error) {
                console.log(error);
            }
        },
        //PopUp
        popMedicamento() {
            try {
                this.popUpMedicamento = true;
            } catch (error) {
                console.log(error);
            }
        },
        popModificarMedicamento(
            id,
            CODART_TRACK,
            NOMBRE,
            GENERICO,
            CAT_FARMACIA,
            UNIMEDBASE,
            CONCENTRACION,
            CODART_ONU,
            CODART,
            CODART_BARR,
            UBICACION,
            SECTOR,
            ZGEN,
            idBodega,
            idZona,
            idEstado,
            LABORATORIO,
            CANTXENB,
            idACT_FECVEN,
            idACTLOTE
        ) {
            try {
                this.limpiarCampos();
                this.popUpMedicamentoMod = true;
                this.idMod = id;
                this.codigoBarra = CODART_BARR;
                this.codigoTrack = CODART_TRACK;
                this.codigoOnu = CODART_ONU;
                this.codigoArticulo = CODART;
                this.nombre = NOMBRE;
                this.generico = GENERICO;
                this.categoriaFarmacia = CAT_FARMACIA;
                this.unidadMedidaBase = UNIMEDBASE;
                this.concentracion = CONCENTRACION;
                let c = this.listaEstado;

                c.forEach((value, index) => {
                    if (idEstado == value.id) {
                        this.seleccionEstado.id = value.id;
                        this.seleccionEstado.descripcionEstado =
                            value.descripcionEstado;
                    }
                });

                c = [];
                this.laboratorio = LABORATORIO;
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
                if (idACT_FECVEN == 1) {
                    this.seleccionFechaVenciminento = {
                        id: 1,
                        descripcionFVen: "Si"
                    };
                } else {
                    this.seleccionFechaVenciminento = {
                        id: 2,
                        descripcionFVen: "No"
                    };
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
                this.sector = SECTOR;
                this.ubicacion = UBICACION;
                this.zgen = ZGEN;
            } catch (error) {
                console.log(error);
            }
        },
        popAgregarCodMedicamento(
            CODART_TRACK,
            NOMBRE,
            GENERICO,
            CAT_FARMACIA,
            UNIMEDBASE,
            CONCENTRACION,
            CODART_ONU,
            CODART,
            CODART_BARR,
            UBICACION,
            SECTOR,
            ZGEN,
            idBodega,
            idZona,
            idEstado,
            LABORATORIO,
            CANTXENB,
            idACT_FECVEN,
            idACTLOTE
        ) {
            try {
                this.limpiarCampos();
                this.popUpNCMedicamento = true;
                this.codigoBarra = CODART_BARR;
                this.codigoTrack = CODART_TRACK;
                this.codigoOnu = CODART_ONU;
                this.codigoArticulo = CODART;
                this.nombre = NOMBRE;
                this.generico = GENERICO;
                this.categoriaFarmacia = CAT_FARMACIA;
                this.unidadMedidaBase = UNIMEDBASE;
                this.concentracion = CONCENTRACION;
                let c = this.listaEstado;

                c.forEach((value, index) => {
                    if (idEstado == value.id) {
                        this.seleccionEstado.id = value.id;
                        this.seleccionEstado.descripcionEstado =
                            value.descripcionEstado;
                    }
                });

                c = [];
                this.laboratorio = LABORATORIO;
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
                if (idACT_FECVEN == 1) {
                    this.seleccionFechaVenciminento = {
                        id: 1,
                        descripcionFVen: "Si"
                    };
                } else {
                    this.seleccionFechaVenciminento = {
                        id: 2,
                        descripcionFVen: "No"
                    };
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
                this.sector = SECTOR;
                this.ubicacion = UBICACION;
                this.zgen = ZGEN;

                this.TraerDetalleByCodInterno(CODART);
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD
        TraerDetalleByCodInterno(codigoInterno) {
            try {
                let data = { CODART: codigoInterno };

                const dat = data;

                axios
                    .post(
                        this.localVal +
                            "/api/Mantenedor/GetListadoMedicamentosByCodInterno",
                        dat,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listaCodNuevo = res.data;
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerMedicamentos() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetMedicamentos", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.rows = res.data;
                        if (this.rows.length < 0) {
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
        AgregarMedicamento() {
            try {
                if (this.seleccionBodega.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "No hay datos, Revise y intente nuevamente",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionFamilia1.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "No hay datos, Revise y intente nuevamente",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.nombre == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "No hay datos, Revise y intente nuevamente",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.codigoArticulo == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "No hay datos, Revise y intente nuevamente",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let boolFVen = false;
                    if (this.seleccionFechaVenciminento.id == 1) {
                        boolFVen = true;
                    } else {
                        boolFVen = true;
                    }

                    let boolFLoteSerie = false;
                    if (this.seleccionLoteSerie.id == 1) {
                        boolFLoteSerie = true;
                    } else {
                        boolFLoteSerie = true;
                    }

                    let data = {
                        CODART_BARR: this.codigoBarra.toUpperCase(),
                        CODART_TRACK: this.codigoTrack.toUpperCase(),
                        CODART_ONU: this.codigoOnu.toUpperCase(),
                        CODART: this.codigoArticulo.toUpperCase(),
                        NOMBRE: this.nombre.toUpperCase(),
                        GENERICO: this.generico.toUpperCase(),
                        CAT_FARMACIA: this.categoriaFarmacia.toUpperCase(),
                        UNIMEDBASE: this.unidadMedidaBase.toUpperCase(),
                        CONCENTRACION: this.concentracion.toUpperCase(),
                        idEstado: this.seleccionEstado.id,
                        ACT_FECVEN: boolFVen,
                        ACT_LOTE: boolFLoteSerie,
                        LABORATORIO: this.laboratorio.toUpperCase(),
                        CANTXENB: this.cantidadEmbalaje,
                        idBodega: this.seleccionBodega.id,
                        idZona: this.seleccionZona.id,
                        SECTOR: this.sector.toUpperCase(),
                        UBICACION: this.ubicacion.toUpperCase(),
                        ZGEN: this.zgen.toUpperCase()
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/Mantenedor/PostMedicamentos",
                            dat,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.limpiarCampos();
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text: "Medicamento Ingresado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpMedicamento = false;
                                this.TraerMedicamentos();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible registrar el medicamento,intentelo nuevamente",
                                    color: "danger",
                                    position: "top-right"
                                });
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        ModificarMedicamento() {
            try {
                if (this.seleccionBodega.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "No hay datos, Revise y intente nuevamente",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionFamilia1.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "No hay datos, Revise y intente nuevamente",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.nombre == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "No hay datos, Revise y intente nuevamente",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.codigoArticulo == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "No hay datos, Revise y intente nuevamente",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let boolFVen = false;
                    if (this.seleccionFechaVenciminento.id == 1) {
                        boolFVen = true;
                    } else {
                        boolFVen = true;
                    }

                    let boolFLoteSerie = false;
                    if (this.seleccionLoteSerie.id == 1) {
                        boolFLoteSerie = true;
                    } else {
                        boolFLoteSerie = true;
                    }

                    let data = {
                        id: this.idMod,
                        CODART_BARR: this.codigoBarra.toUpperCase(),
                        CODART_TRACK: this.codigoTrack.toUpperCase(),
                        CODART_ONU: this.codigoOnu.toUpperCase(),
                        CODART: this.codigoArticulo.toUpperCase(),
                        NOMBRE: this.nombre.toUpperCase(),
                        GENERICO: this.generico.toUpperCase(),
                        CAT_FARMACIA: this.categoriaFarmacia.toUpperCase(),
                        UNIMEDBASE: this.unidadMedidaBase.toUpperCase(),
                        CONCENTRACION: this.concentracion.toUpperCase(),
                        idEstado: this.seleccionEstado.id,
                        ACT_FECVEN: boolFVen,
                        ACT_LOTE: boolFLoteSerie,
                        LABORATORIO: this.laboratorio.toUpperCase(),
                        CANTXENB: this.cantidadEmbalaje,
                        idBodega: this.seleccionBodega.id,
                        idZona: this.seleccionZona.id,
                        SECTOR: this.sector.toUpperCase(),
                        UBICACION: this.ubicacion.toUpperCase(),
                        ZGEN: this.zgen.toUpperCase()
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/Mantenedor/PutMedicamentos",
                            dat,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.limpiarCampos();
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text:
                                        "Medicamento Modificado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpMedicamentoMod = false;
                                this.TraerMedicamentos();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible modificar el medicamento,intentelo nuevamente",
                                    color: "danger",
                                    position: "top-right"
                                });
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        ValidarCodigoBarra() {
            try {
                let data = {
                    CODART_BARR: this.codigoBarra
                };

                const dat = data;

                axios
                    .post(
                        this.localVal +
                            "/api/Mantenedor/PostValidarCodBarraMed",
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
                            this.AgregarCodigoMedicamento();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue Codigo de barra ya ingresado,intente con otro codigo",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarCodigoMedicamento() {
            try {
                let boolFVen = false;
                if (this.seleccionFechaVenciminento.id == 1) {
                    boolFVen = true;
                } else {
                    boolFVen = true;
                }

                let boolFLoteSerie = false;
                if (this.seleccionLoteSerie.id == 1) {
                    boolFLoteSerie = true;
                } else {
                    boolFLoteSerie = true;
                }

                let data = {
                    CODART_BARR: this.codigoBarra.toUpperCase(),
                    CODART_TRACK: this.codigoTrack.toUpperCase(),
                    CODART_ONU: this.codigoOnu.toUpperCase(),
                    CODART: this.codigoArticulo.toUpperCase(),
                    NOMBRE: this.nombre.toUpperCase(),
                    GENERICO: this.generico.toUpperCase(),
                    CAT_FARMACIA: this.categoriaFarmacia.toUpperCase(),
                    UNIMEDBASE: this.unidadMedidaBase.toUpperCase(),
                    CONCENTRACION: this.concentracion.toUpperCase(),
                    idEstado: this.seleccionEstado.id,
                    ACT_FECVEN: boolFVen,
                    ACT_LOTE: boolFLoteSerie,
                    LABORATORIO: this.laboratorio.toUpperCase(),
                    CANTXENB: this.cantidadEmbalaje,
                    idBodega: this.seleccionBodega.id,
                    idZona: this.seleccionZona.id,
                    SECTOR: this.sector.toUpperCase(),
                    UBICACION: this.ubicacion.toUpperCase(),
                    ZGEN: this.zgen.toUpperCase()
                };

                const dat = data;

                axios
                    .post(
                        this.localVal + "/api/Mantenedor/PostCodMedicamentos",
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
                                    "Codigo Medicamento Agregado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.TraerMedicamentos();
                            this.TraerDetalleByCodInterno(this.codigoArticulo);
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible modificar el medicamento,intentelo nuevamente",
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
            this.TraerMedicamentos();
            this.TraerEstado();
            this.TraerBodega();
            this.TraerZona();
            this.openLoadingColor();
        }, 2000);
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1000px;
}
</style>
