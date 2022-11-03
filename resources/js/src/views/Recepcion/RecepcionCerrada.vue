<template>
    <div>
        <div class="vx-col md:w-1/1 w-full mb-base">
            <vx-card title="Recepcion">
                <div class="vx-row">
                    <div class="vx-col w-1/2 mt-5">
                        <h6>N° Interno</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="numint"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <h6>N° Folio</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="folio"
                            disabled
                        />
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
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <div class="vx-row" v-if="validarUsuario != 5">
                        <div class="vx-col w-1/3 mt-5">
                            <vs-button
                                @click="popAgregarFactura"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >ADJUNTAR FACTURA</vs-button
                            >
                        </div>
                        <div class="vx-col w-1/3 mt-5">
                            <vs-button
                                @click="popAgregarRIB"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >ADJUNTAR RIB</vs-button
                            >
                        </div>
                        <div class="vx-col w-1/3 mt-5">
                            <vs-button
                                @click="popAgregarCarta"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >ADJUNTAR CARTA</vs-button
                            >
                        </div>
                    </div>
                </div>
                <!-- Detalles Articulos -->
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <vx-card title="">
                        <div class="vx-row">
                            <vue-good-table
                                class="w-full"
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
                                            props.column.field === 'FOLIO'
                                        "
                                    >
                                        <plus-circle-icon
                                            content="Generar Codigo de Barra"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                generarCodigoBarra(
                                                    props.row.PRODUCTO,
                                                    props.row.CODART,
                                                    props.row.FECVEN,
                                                    props.row.LOTE,
                                                    props.row.FOLIO
                                                )
                                            "
                                        ></plus-circle-icon>
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
                                            content="Revertir Anulacion"
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
                            <div class="vx-col w-1/5 mt-5">
                                <vs-button
                                    v-if="validarUsuario != 5"
                                    @click="ActualizarListado"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Actualizar</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/5 mt-5">
                                <vs-button
                                    v-if="validarUsuario != 5"
                                    @click="volver"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/5 mt-5">
                                <vs-button
                                    v-if="validarUsuario != 5"
                                    @click="ImprimirDatos"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Imprimir</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/5 mt-5">
                                <vs-button
                                    v-if="validarUsuario != 5"
                                    @click="popAnularTodo"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Anular Todo</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/5 mt-5">
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
            <div class="vx-row"></div>
        </div>
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
            classContent="RAnulacion"
            title="Revertir Anulacion"
            :active.sync="popUpRAnularArticulo"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="">
                    <div class="vx-row">
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                @click="popUpRAnularArticulo = false"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Volver</vs-button
                            >
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
        <!-- Documento Factura -->
        <vs-popup
            classContent="Factura"
            title="Factura"
            :active.sync="popUpAgregarFactura"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/8 mt-5">
                            <h6 class="pt-4 text-right">ADJUNTAR FACTURA</h6>
                        </div>
                        <div class="vx-col w-1/8 mt-5">
                            <vs-input
                                type="file"
                                id="archivo"
                                @change="getImage"
                                class="form-control w-full"
                            />
                        </div>

                        <div class="vx-col w-1/2 mt-5">
                            <h5 class="w-full pt-4 text-justify">
                                <p>
                                    {{ nombrearchivo }}
                                </p>
                            </h5>
                        </div>
                    </div>
                    <div class="vx-row">
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                @click="popUpAgregarFactura = false"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Volver</vs-button
                            >
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                @click="uploadImage"
                                color="danger"
                                type="filled"
                                class="w-full"
                                >Subir Documento</vs-button
                            >
                        </div>
                    </div>
                </vx-card>
                <div class="vx-row"></div>
            </div>
        </vs-popup>
        <!-- Documento RIB -->
        <vs-popup classContent="RIB" title="RIB" :active.sync="popUpAgregarRIB">
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/8 mt-5">
                            <h6 class="pt-4 text-justify">ADJUNTAR RIB</h6>
                        </div>
                        <div class="vx-col w-1/8 mt-5">
                            <vs-input
                                type="file"
                                id="archivo"
                                @change="getImageRib"
                                class="form-control w-full"
                            />
                        </div>

                        <div class="vx-col w-1/2 mt-5">
                            <h5 class="w-full pt-4 text-justify">
                                <p>
                                    {{ nombrearchivoRib }}
                                </p>
                            </h5>
                        </div>
                    </div>
                    <div class="vx-row">
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                @click="popUpAgregarRIB = false"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Volver</vs-button
                            >
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                @click="uploadImageRib"
                                color="danger"
                                type="filled"
                                class="w-full"
                                >Subir Documento</vs-button
                            >
                        </div>
                    </div>
                </vx-card>
                <div class="vx-row"></div>
            </div>
        </vs-popup>
        <!-- Documento CARTA -->
        <vs-popup
            classContent="CARTA"
            title="CARTA"
            :active.sync="popUpAgregarCarta"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/8 mt-5">
                            <h6 class="pt-4 text-justify">ADJUNTAR CARTA</h6>
                        </div>
                        <div class="vx-col w-1/8 mt-5">
                            <vs-input
                                type="file"
                                id="archivo"
                                @change="getImageCarta"
                                class="form-control w-full"
                            />
                        </div>

                        <div class="vx-col w-1/2 mt-5">
                            <h5 class="w-full pt-4 text-justify">
                                <p>
                                    {{ nombrearchivoCarta }}
                                </p>
                            </h5>
                        </div>
                    </div>
                    <div class="vx-row">
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                @click="popUpAgregarCarta = false"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Volver</vs-button
                            >
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                @click="uploadImageCarta"
                                color="danger"
                                type="filled"
                                class="w-full"
                                >Subir Documento</vs-button
                            >
                        </div>
                    </div>
                </vx-card>
                <div class="vx-row"></div>
            </div>
        </vs-popup>
        <vs-popup
            classContent="CodigodeBarra"
            title="Codigo de Barra"
            :active.sync="popCodigoBarra"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="">
                    <div class="vx-row">
                        <div class="vx-col w-1/2 mt-5 justify-right">
                            <h6>
                                Codigo de Barra
                            </h6>
                            <br />
                            <h6>
                                C. 1234324323
                            </h6>
                            <br />
                            <h6>
                                V. 01/01/2011 L. GFCFS3
                            </h6>
                        </div>
                        <div class="vx-col w-1/2 mt-5 justify-left">
                            <barcode
                                v-bind:value="barcodeValue"
                                format="codabar"
                            >
                                Fallo
                            </barcode>
                        </div>
                    </div>
                </vx-card>
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
import VueBarcode from "vue-barcode";
Vue.use(VueTippy);
Vue.component("tippy", TippyComponent);

export default {
    components: {
        VueGoodTable,
        "v-select": vSelect,
        quillEditor,
        PlusCircleIcon,
        flatPickr,
        barcode: VueBarcode
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
            validarUsuario: sessionStorage.getItem("permiso_usuario"),
            image: null,
            nombrearchivo: "",
            imageRib: null,
            nombrearchivoRib: "",
            imageCarta: null,
            nombrearchivoCarta: "",
            val_doc: 0,
            idAnulacion: 0,
            popUpAnularArticulo: false,
            popUpRAnularArticulo: false,
            popUpAnularTodo: false,
            popUpAgregarFactura: false,
            popUpAgregarRIB: false,
            popUpAgregarCarta: false,
            FVEN1: "Si",
            FVEN2: "No",
            codInternoRecepcion: 0,
            descripcionServicio: "",
            ndocumento: "",
            cantidad: 0,
            precio: 0,
            numint: 0,
            folio: 0,
            valorTotal: 0,
            fechaSistema: null,
            fechaRecepcion: null,
            fechaDocumento: null,
            fechaVencimiento: null,
            codigoBarra: "",
            Observaciones: "-",
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
            lote: "",
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
            barcodeValue: null,
            popCodigoBarra: false,
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
            seleccionAnulacion: {
                id: 0,
                CODMOT: "",
                NOMMOT: ""
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
                },
                {
                    label: "Anulado?",
                    field: "NOMMOT",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Generar Codigo de barra",
                    field: "FOLIO"
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
                    field: "NETO"
                },
                {
                    label: "Descuento",
                    field: "DCTO"
                },
                {
                    label: "Cargos",
                    field: "CARGO"
                },
                {
                    label: "Sub Total",
                    field: "SUBTOTAL"
                },
                {
                    label: "19% Iva",
                    field: "IVA"
                },
                {
                    label: "Ajuste",
                    field: "AJUSTE"
                },
                {
                    label: "Total",
                    field: "TOTAL"
                }
            ],
            //Datos Listado
            rows: [],
            listaArticulos: [],
            listaDetalleRecepcion: [],
            listadoAnulacion: [],
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
        generarCodigoBarra(producto, codart, fecven, lote, folio) {
            try {
                this.barcodeValue = folio;
                this.popCodigoBarra = true;
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
        ActualizarListado() {
            try {
                let dat = {
                    NUMINT: this.numint,
                    OBS: this.Observaciones.toUpperCase()
                };

                axios
                    .post(
                        this.localVal + "/api/Mantenedor/PutRecepcionTotal",
                        dat,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        let resp = res.data;
                        if (resp == true) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text: "Observacion actualizada Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.TraerRecepcion();
                            this.TraerDetalleRecepcion();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible actualizar la Observacion,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        //Funciones Finales Recepcion
        popAnularArticulo(id) {
            try {
                this.idAnulacion = 0;
                this.idAnulacion = id;
                this.popUpAnularArticulo = true;
            } catch (error) {
                console.log(error);
            }
        },
        //Funciones Finales Recepcion
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
                if (this.numint != 0 && this.folio != 0) {
                    const url =
                        this.localVal +
                        "/api/Recepcion/RecepcionPDF/" +
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
        popAgregarFactura() {
            try {
                this.popUpAgregarFactura = true;
            } catch (error) {
                console.log(error);
            }
        },
        popAgregarRIB() {
            try {
                this.popUpAgregarRIB = true;
            } catch (error) {
                console.log(error);
            }
        },
        popAgregarCarta() {
            try {
                this.popUpAgregarCarta = true;
            } catch (error) {
                console.log(error);
            }
        },
        getImage(event) {
            //Asignamos la imagen a  nuestra data
            this.image = event.target.files[0];
            this.nombrearchivo = this.image.name;
            this.val_doc = 1;
        },
        getImageRib(event) {
            //Asignamos la imagen a  nuestra data
            this.imageRib = event.target.files[0];
            this.nombrearchivoRib = this.imageRib.name;
            this.val_doc = 1;
        },
        getImageCarta(event) {
            //Asignamos la imagen a  nuestra data
            this.imageCarta = event.target.files[0];
            this.nombrearchivoCarta = this.imageCarta.name;
            this.val_doc = 1;
        },
        uploadImage() {
            //Creamos el formData

            var data = new FormData();
            //Añadimos la imagen seleccionada
            data.append("avatar", this.image);
            data.append("id", this.numint);
            data.append("nombreDocOriginal", this.nombrearchivo);

            axios
                .post(
                    this.localVal +
                        "/api/Recepcion/PostDocumentoRecepcionFactura",
                    data,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    }
                )
                .then(response => {
                    let resp = response.data;
                    if (resp == true) {
                        this.$vs.notify({
                            title: "Documento Guardado ",
                            text:
                                "Podra Visualizarlo en el listado los usuarios autorizados ",
                            color: "success",
                            position: "top-right"
                        });
                        this.TraerRecepcion();
                    } else {
                        this.$vs.notify({
                            title: "Error al subir el documento ",
                            text:
                                "Intente nuevamente con el formato PDF o alguna Imagen ",
                            color: "danger",
                            position: "top-right"
                        });
                    }
                });
        },
        uploadImageRib() {
            //Creamos el formData

            var data = new FormData();
            //Añadimos la imagen seleccionada
            data.append("avatar", this.imageRib);
            data.append("id", this.numint);
            data.append("nombreDocOriginal", this.nombrearchivoRib);

            axios
                .post(
                    this.localVal +
                        "/api/Recepcion/PostDocumentoRecepcionFacturaRib",
                    data,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    }
                )
                .then(response => {
                    let resp = response.data;
                    if (resp == true) {
                        this.$vs.notify({
                            title: "Documento Guardado ",
                            text:
                                "Podra Visualizarlo en el listado los usuarios autorizados ",
                            color: "success",
                            position: "top-right"
                        });
                        this.TraerRecepcion();
                    } else {
                        this.$vs.notify({
                            title: "Error al subir el documento ",
                            text:
                                "Intente nuevamente con el formato PDF o alguna Imagen ",
                            color: "danger",
                            position: "top-right"
                        });
                    }
                });
        },
        uploadImageCarta() {
            //Creamos el formData

            var data = new FormData();
            //Añadimos la imagen seleccionada
            data.append("avatar", this.imageCarta);
            data.append("id", this.numint);
            data.append("nombreDocOriginal", this.nombrearchivoCarta);

            axios
                .post(
                    this.localVal +
                        "/api/Recepcion/PostDocumentoRecepcionFacturaCarta",
                    data,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    }
                )
                .then(response => {
                    let resp = response.data;
                    if (resp == true) {
                        this.$vs.notify({
                            title: "Documento Guardado ",
                            text:
                                "Podra Visualizarlo en el listado los usuarios autorizados ",
                            color: "success",
                            position: "top-right"
                        });
                        this.TraerRecepcion();
                    } else {
                        this.$vs.notify({
                            title: "Error al subir el documento ",
                            text:
                                "Intente nuevamente con el formato PDF o alguna Imagen ",
                            color: "danger",
                            position: "top-right"
                        });
                    }
                });
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
                        this.localVal + "/api/Recepcion/PostAnularTodo",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
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
                                    "No se pudo anular la recepcion, intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Finalizado",
                                text: "Recepcion anulado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.popUpAnularTodo = false;
                            this.TraerDetalleRecepcion();
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
                        this.localVal + "/api/Recepcion/PostAnularArticulo",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
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
                            this.TraerDetalleRecepcion();
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
                        this.localVal + "/api/Recepcion/PostRAnularArticulo",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
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
                                    "No se pudo revertir la anulacion del articulo, intentelo nuevamente",
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
                            this.TraerDetalleRecepcion();
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        volver() {
            try {
                this.$router.push({
                    name: "ListadoRecepcionCerrada"
                });
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD
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
        TraerAnulaciones() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetAnulacion", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
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
                            let nomser = "";

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
                                this.folio = value.FOLIO;
                                this.Observaciones = value.OBS;
                                nomser = value.NOMSER;
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
        },
        //Firma Digital
        AgregarListadoFirmaUsers() {
            try {
                let run = sessionStorage.getItem("run");
                if (run.length == 10) {
                    run = run.substring(0, 8);
                } else if (run == 9) {
                    run = run.substring(0, 7);
                }

                let data = {
                    RUN: run,
                    idPerfil: sessionStorage.getItem("permiso_usuario"),
                    NUMINT: this.numint
                };

                axios
                    .post(
                        this.localVal + "/api/Firma/PostUsuarioRecepcionFirma",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
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
                    .post(this.localVal + "/api/Firma/FirmaDigitalArray", dat, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
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
            this.TraerTipoDocumentos();
            this.TraerProveedores();
            this.TraerEstado();
            this.TraerBodega();
            this.TraerZona();
            this.TraerAnulaciones();
            this.TraerDetalleRecepcion();
            this.TraerRecepcion();
            this.cargarHoras();
            this.openLoadingColor();
        }, 2000);
    }
};
</script>
<style lang="stylus">
#archivo{
   width: 155px;
}

.con-vs-popup .vs-popup {
  width: 1500px;
}
</style>
