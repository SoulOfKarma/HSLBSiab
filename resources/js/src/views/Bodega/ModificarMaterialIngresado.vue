<template>
    <div>
        <vs-row>
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card>
                    <vs-alert active="true" color="success">
                        Historial Material - Agente:
                        {{ nombre }} - {{ run }}
                    </vs-alert>
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.1 - Ubicacion</h6>
                            <br />
                            <v-select
                                v-model="seleccionUbicacion"
                                placeholder="Ubicacion"
                                class="w-full select-large"
                                label="descripcion_ubicacion"
                                :options="listadoUbicacion"
                                @input="filtroSegunUbicacion"
                            >
                            </v-select>
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.2 - Servicio</h6>
                            <br />
                            <v-select
                                v-model="seleccionServicio"
                                placeholder="Servicio"
                                class="w-full select-large"
                                label="descripcion_servicio"
                                :options="listadoServicio"
                                @input="filtroSegunServicio"
                            >
                            </v-select>
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.3 - Material</h6>
                            <br />
                            <v-select
                                taggable
                                v-model="seleccionMaterial"
                                placeholder="Material"
                                class="w-full select-large"
                                label="descripcion_material"
                                :options="listadoMaterial"
                                @input="filtroSegunMaterial"
                            ></v-select>
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.4 - Tipo Material</h6>
                            <br />
                            <v-select
                                taggable
                                v-model="seleccionTipoMaterial"
                                placeholder="Tipo Material"
                                class="w-full select-large"
                                label="descripcion_tipo_material"
                                :options="listadoTipoMaterial"
                                @input="CrearValidarTipoMaterial()"
                            ></v-select>
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.5 - Contenido</h6>
                            <br />
                            <v-select
                                taggable
                                v-model="seleccionCantEsp"
                                placeholder="Cantidad Esp."
                                class="w-full select-large"
                                label="descripcion_cantidad_especifica"
                                :options="listadoCantEsp"
                                @input="crearValidarCantEsp"
                            ></v-select>
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.6 - Medida</h6>
                            <br />
                            <v-select
                                v-model="seleccionMedidas"
                                placeholder="Medidas"
                                class="w-full select-large"
                                label="descripcion_medidas"
                                :options="listadoMedidas"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.7 - Cantidad</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                v-model="cantidad"
                                @input="CalcTotal"
                                :step="0.5"
                                @keypress="isNumber($event)"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.8 - Valor</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                v-model="valor"
                                @input="valorTotal"
                                :step="0.5"
                                @keypress="isNumber($event)"
                            ></vs-input>
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>Total Segun Medida.</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                v-model="total"
                                :step="0.5"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>Total Valor.</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                v-model="totalValor"
                                :step="0.5"
                            />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.9 - Documento</h6>
                            <br />
                            <v-select
                                v-model="seleccionDocumento"
                                placeholder="Documento"
                                class="w-full select-large"
                                label="descripcion_documento"
                                :options="listadoDocumentoAsociado"
                            ></v-select>
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.10 - N° Documento</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                v-model="ndocumento"
                            ></vs-input>
                            <br />
                        </div>
                        <div class="vx-col w-full mt-5">
                            <h6>2.1 - Razon del Cambio</h6>
                            <br />
                            <quill-editor
                                class="w-full"
                                v-model="descripcion_seguimiento"
                                :options="editorOption"
                            >
                                <div id="toolbar" slot="toolbar"></div>
                            </quill-editor>
                        </div>

                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                class="w-full"
                                color="primary"
                                type="filled"
                                @click="volver"
                                >Volver</vs-button
                            >
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                class="w-full"
                                color="warning"
                                type="filled"
                                @click="guardarCambios"
                                >Guardar</vs-button
                            >
                        </div>
                    </div>
                </vx-card>
            </div>
        </vs-row>
        <vs-popup
            classContent="pop-Crear"
            title="Guardar Nuevo Material?"
            :active.sync="popActiveMaterial"
        >
            <vs-input class="inputx mb-3" v-model="desMaterial" hidden />
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            color="warning"
                            type="filled"
                            class="w-full m-2"
                            @click="guardarMaterial(desMaterial)"
                        >
                            Guardar
                        </vs-button>
                    </div>
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            class="w-full m-2"
                            @click="popActiveMaterial = false"
                            color="primary"
                            type="filled"
                            >Volver</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-popup>
        <vs-popup
            classContent="pop-CrearTipo"
            title="Guardar Nuevo Tipo de Material?"
            :active.sync="popActiveTMaterial"
        >
            <vs-input class="inputx mb-3" v-model="desTipoMaterial" hidden />
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            color="warning"
                            type="filled"
                            class="w-full m-2"
                            @click="guardarTipoMaterial(desTipoMaterial)"
                        >
                            Guardar
                        </vs-button>
                    </div>
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            class="w-full m-2"
                            @click="popActiveTMaterial = false"
                            color="primary"
                            type="filled"
                            >Volver</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-popup>
        <vs-popup
            classContent="pop-CrearTipo"
            title="Guardar Nuevo Tipo de Material?"
            :active.sync="popActiveCantidadEsp"
        >
            <vs-input class="inputx mb-3" v-model="desCantEsp" hidden />
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            color="warning"
                            type="filled"
                            class="w-full m-2"
                            @click="guardarCantidadEspecifica(desCantEsp)"
                        >
                            Guardar
                        </vs-button>
                    </div>
                    <div class="vx-col sm:w-full w-full">
                        <vs-button
                            class="w-full m-2"
                            @click="popActiveCantidadEsp = false"
                            color="primary"
                            type="filled"
                            >Volver</vs-button
                        >
                    </div>
                </div>
            </div>
        </vs-popup>
    </div>
</template>
<script>
import axios from "axios";
import router from "@/router";
import { InfoIcon } from "vue-feather-icons";
import { PlusCircleIcon } from "vue-feather-icons";
import { Trash2Icon } from "vue-feather-icons";
import { UploadIcon } from "vue-feather-icons";
import { CornerDownRightIcon } from "vue-feather-icons";
import { ArchiveIcon } from "vue-feather-icons";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import Vue from "vue";
import Vuesax from "vuesax";
import vSelect from "vue-select";
export default {
    components: {
        ArchiveIcon,
        InfoIcon,
        PlusCircleIcon,
        Trash2Icon,
        UploadIcon,
        CornerDownRightIcon,
        quillEditor,
        "v-select": vSelect
    },
    data: () => ({
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
        descripcion_seguimiento: "",
        nombre:
            sessionStorage.getItem("nombre") +
            " " +
            sessionStorage.getItem("apellido"),
        run: sessionStorage.getItem("run"),
        materialSeleccion: {
            id: 0,
            id_ubicaciones: "",
            id_servicios: "",
            id_material_ing: "",
            id_material_tipo: "",
            id_cant_esp: "",
            id_material_medida: "",
            material_cantidad: "",
            material_valor: "",
            id_documento: "",
            n_documento: "",
            descripcion_seguimiento: ""
        },
        seleccionUbicacion: {
            id: 0,
            descripcion_ubicacion: "Seleccione Ubicacion"
        },
        seleccionServicio: {
            id: 0,
            descripcion_servicio: "Seleccione Servicio"
        },
        seleccionMedidas: {
            id: 8,
            descripcion_medidas: "UN"
        },
        seleccionMaterial: {
            id: 0,
            descripcion_material: "Seleccione Material"
        },
        seleccionTipoMaterial: {
            id: 0,
            descripcion_tipo_material: "Selecione Tipo Material"
        },
        seleccionCantEsp: {
            id: 0,
            descripcion_cantidad_especifica: "400"
        },
        seleccionDocumento: {
            id: 0,
            descripcion_documento: "Seleccione Documento"
        },
        listadoUbicacion: [],
        listadoUbicacionData: [],
        listadoServicio: [],
        listadoServicioData: [],
        listadoMedidas: [],
        listadoMedidasData: [],
        listadoMaterial: [],
        listadoMaterialData: [],
        listadoTipoMaterial: [],
        listadoTipoMaterialData: [],
        listadoCantEsp: [],
        listadoCantEspData: [],
        listadoDocumentoAsociado: [],
        cantidad: 0,
        valor: 0,
        total: 0,
        totalMaterial: 0,
        totalValor: 0,
        desMaterial: "",
        desTipoMaterial: "",
        desCantEsp: "",
        idMaterial: 0,
        medida: "cc",
        ndocumento: "",
        localVal: process.env.MIX_APP_URL,
        popActiveMaterial: false,
        popActiveTMaterial: false,
        popActiveCantidadEsp: false
    }),
    methods: {
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
            router.back();
        },
        guardarCambios() {
            if (
                this.seleccionUbicacion.id == 0 ||
                this.seleccionUbicacion.id == null
            ) {
                this.$vs.notify({
                    time: 3000,
                    title: " Ubicacion no seleccionada o con error",
                    text: "Seleccionela Nuevamente",
                    color: "danger",
                    position: "top-right"
                });
            } else if (
                this.seleccionServicio.id == 0 ||
                this.seleccionServicio.id == null
            ) {
                this.$vs.notify({
                    time: 3000,
                    title: " Servicio no seleccionado o con error",
                    text: "Seleccionela nuevamente",
                    color: "danger",
                    position: "top-right"
                });
            } else if (
                this.seleccionMaterial.id == 0 ||
                this.seleccionMaterial.id == null
            ) {
                this.$vs.notify({
                    time: 3000,
                    title: " Material no seleccionado o con error",
                    text: "Seleccionela nuevamente",
                    color: "danger",
                    position: "top-right"
                });
            } else if (
                this.seleccionTipoMaterial.id == 0 ||
                this.seleccionTipoMaterial.id == null ||
                null
            ) {
                this.$vs.notify({
                    time: 3000,
                    title: " Tipo Material Agregado Correctamente",
                    text: "Seleccionela nuevamente",
                    color: "danger",
                    position: "top-right"
                });
            } else if (
                this.seleccionCantEsp.id == 0 ||
                this.seleccionCantEsp.id == null
            ) {
                this.$vs.notify({
                    time: 3000,
                    title: " Contenido no seleccionado o con error",
                    text: "Seleccionelo nuevamente",
                    color: "danger",
                    position: "top-right"
                });
            } else if (
                this.seleccionMedidas.id == 0 ||
                this.seleccionMedidas.id == null
            ) {
                this.$vs.notify({
                    time: 3000,
                    title: " Medida no seleccionada o con error",
                    text: "Seleccionela nuevamente",
                    color: "danger",
                    position: "top-right"
                });
            } else if (this.cantidad <= 0 || this.cantidad == null) {
                this.$vs.notify({
                    time: 3000,
                    title: " Campo cantidad vacio",
                    text: "Ingrese cantidad para continuar",
                    color: "danger",
                    position: "top-right"
                });
            } else if (this.valor <= 0 || this.valor == null) {
                this.$vs.notify({
                    time: 3000,
                    title: " Campo valor vacio",
                    text: "Ingrese valor para continuar",
                    color: "danger",
                    position: "top-right"
                });
            } else if (
                this.seleccionDocumento.id == 0 ||
                this.seleccionDocumento == null
            ) {
                this.$vs.notify({
                    time: 3000,
                    title: " Tipo Documento no seleccionado o con error",
                    text: "Seleccione nuevamente",
                    color: "danger",
                    position: "top-right"
                });
            } else if (this.ndocumento == "" || this.ndocumento == null) {
                this.$vs.notify({
                    time: 3000,
                    title: "Campo N° Documento Vacio ",
                    text: "Ingrese el N° de documento",
                    color: "danger",
                    position: "top-right"
                });
            } else if (
                this.descripcion_seguimiento == "" ||
                this.descripcion_seguimiento == null
            ) {
                this.$vs.notify({
                    time: 3000,
                    title: " Campo Razon de cambio vacio",
                    text: "Ingrese la razon para continuar",
                    color: "danger",
                    position: "top-right"
                });
            } else {
                console.log("Hola");
            }
        },

        filtroSegunServicio() {
            if (this.seleccionServicio == null || this.seleccionServicio == 0) {
                this.listadoUbicacion = this.listadoUbicacionData;
                this.listadoServicio = this.listadoServicioData;
            } else {
                let idGen = this.seleccionServicio.id_material_ubicacion;
                let c = this.listadoUbicacionData;
                let b = [];
                let a = 0;
                c.forEach((value, index) => {
                    a = value.id;
                    if (a == idGen) {
                        b.push(value);
                    }
                });
                this.seleccionUbicacion.id = b[0].id;
                this.seleccionUbicacion.descripcion_ubicacion =
                    b[0].descripcion_ubicacion;
            }
        },
        filtroSegunUbicacion() {
            if (
                this.seleccionUbicacion == null ||
                this.seleccionUbicacion == 0
            ) {
                this.listadoUbicacion = this.listadoUbicacionData;
                this.listadoServicio = this.listadoServicioData;
            } else {
                var idGen = this.seleccionUbicacion.id;
                let c = this.listadoServicioData;
                let b = [];
                let a = 0;
                c.forEach((value, index) => {
                    a = value.id_material_ubicacion;
                    if (a == idGen) {
                        b.push(value);
                    }
                });
                this.listadoServicio = b;
            }
        },
        filtroSegunMaterial() {
            try {
                if (
                    this.seleccionMaterial.id == 0 ||
                    this.seleccionMaterial.id == null
                ) {
                    if (
                        this.seleccionMaterial.descripcion_material ===
                            undefined ||
                        this.seleccionMaterial.descripcion_material === "" ||
                        this.seleccionMaterial.descripcion_material === null
                    ) {
                        this.desMaterial = this.seleccionMaterial;
                        this.popActiveMaterial = true;
                    } else {
                        this.desMaterial = this.seleccionMaterial.descripcion_material;
                        this.popActiveMaterial = true;
                    }
                } else {
                    let idGen = this.seleccionMaterial.id;
                    let c = this.listadoTipoMaterialData;
                    let b = [];
                    let a = 0;
                    c.forEach((value, index) => {
                        a = value.id_material;
                        if (a == idGen) {
                            b.push(value);
                        }
                    });
                    this.listadoTipoMaterial = b;
                    this.seleccionTipoMaterial = {
                        id: 0,
                        descripcion_tipo_material: ""
                    };
                }
            } catch (error) {
                console.log(error);
            }
        },
        CrearValidarTipoMaterial() {
            try {
                if (
                    this.seleccionTipoMaterial.id == 0 ||
                    this.seleccionTipoMaterial.id == null
                ) {
                    if (
                        this.seleccionTipoMaterial.descripcion_tipo_material ===
                            undefined ||
                        this.seleccionTipoMaterial.descripcion_tipo_material ===
                            null ||
                        this.seleccionTipoMaterial.descripcion_tipo_material ==
                            ""
                    ) {
                        if (
                            this.seleccionMaterial.id == 0 ||
                            this.seleccionMaterial.id == null
                        ) {
                            this.$vs.notify({
                                time: 3000,
                                title: "Debe Seleccionar Material",
                                text:
                                    "Debe estar Seleccionado Para asociar el nuevo tipo de material",
                                color: "warning",
                                position: "top-right"
                            });
                        } else {
                            console.log(this.seleccionMaterial);
                            this.idMaterial = this.seleccionMaterial.id;
                            this.desTipoMaterial = this.seleccionTipoMaterial;
                            this.popActiveTMaterial = true;
                        }
                    } else {
                        if (
                            this.seleccionMaterial.id == 0 ||
                            this.seleccionMaterial.id == null
                        ) {
                            this.$vs.notify({
                                time: 3000,
                                title: "Debe Seleccionar Material",
                                text:
                                    "Debe estar Seleccionado Para asociar el nuevo tipo de material",
                                color: "warning",
                                position: "top-right"
                            });
                        } else {
                            console.log(this.seleccionMaterial.id);
                            this.idMaterial = this.seleccionMaterial.id;
                            this.desTipoMaterial = this.seleccionTipoMaterial.descripcion_tipo_material;
                            this.popActiveTMaterial = true;
                        }
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },
        crearValidarCantEsp() {
            try {
                if (
                    this.seleccionCantEsp.id == 0 ||
                    this.seleccionCantEsp.id == null
                ) {
                    if (
                        this.seleccionCantEsp
                            .descripcion_cantidad_especifica === undefined ||
                        this.seleccionCantEsp
                            .descripcion_cantidad_especifica === null ||
                        this.seleccionCantEsp.descripcion_cantidad_especifica ==
                            ""
                    ) {
                        this.desCantEsp = this.seleccionCantEsp;
                        this.popActiveCantidadEsp = true;
                    } else {
                        this.desCantEsp = this.seleccionCantEsp.descripcion_cantidad_especifica;
                        this.popActiveCantidadEsp = true;
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },
        cargarUbicaciones() {
            axios
                .get(this.localVal + "/api/Bodega/GetUbicaciones", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoUbicacion = res.data;
                    this.listadoUbicacionData = res.data;
                });
        },
        cargarServicios() {
            axios
                .get(this.localVal + "/api/Bodega/GetServicios", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoServicio = res.data;
                    this.listadoServicioData = res.data;
                });
        },
        cargarMedidas() {
            axios
                .get(this.localVal + "/api/Bodega/GetMedidasFiltradas", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoMedidas = res.data;
                    this.listadoMedidasData = res.data;
                });
        },
        cargarMaterial() {
            axios
                .get(this.localVal + "/api/Bodega/GetMaterial", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoMaterial = res.data;
                    this.listadoMaterialData = res.data;
                });
        },
        cargarTipoMaterial() {
            axios
                .get(this.localVal + "/api/Bodega/GetTipoMaterial", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoTipoMaterial = res.data;
                    this.listadoTipoMaterialData = res.data;
                });
        },
        cargarDocumentoAsociado() {
            axios
                .get(this.localVal + "/api/Bodega/GetDocumentos", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoDocumentoAsociado = res.data;
                });
        },
        cargarCantidadEspecifica() {
            axios
                .get(this.localVal + "/api/Bodega/GetCantEsp", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoCantEsp = res.data;
                    this.listadoCantEspData = res.data;
                });
        },
        guardarMaterial(valor) {
            let material = {
                descripcion_material: valor
            };

            axios
                .post(this.localVal + "/api/Bodega/PostMaterial", material, {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    if (res.data == true) {
                        this.$vs.notify({
                            time: 3000,
                            title: " Material Agregado Correctamente",
                            text: "Se Recargara Listado",
                            color: "success",
                            position: "top-right"
                        });
                        this.cargarMaterial();
                        this.popActiveMaterial = false;
                    } else {
                        this.$vs.notify({
                            time: 3000,
                            title: "Error Al Guardar Tipo Material",
                            text:
                                "Intente Nuevamente o Consulte con el Administrador",
                            color: "danger",
                            position: "top-right"
                        });
                    }
                });
        },
        guardarTipoMaterial(valor) {
            let material = {
                descripcion_tipo_material: valor,
                id_material: this.idMaterial
            };

            axios
                .post(
                    this.localVal + "/api/Bodega/PostTipoMaterial",
                    material,
                    {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    }
                )
                .then(res => {
                    if (res.data == true) {
                        this.$vs.notify({
                            time: 3000,
                            title: "Tipo Material Agregado Correctamente",
                            text: "Se Recargara Listado",
                            color: "success",
                            position: "top-right"
                        });
                        this.cargarTipoMaterial();
                        this.popActiveTMaterial = false;
                    } else {
                        this.$vs.notify({
                            time: 3000,
                            title: "Error Al Guardar Material",
                            text:
                                "Intente Nuevamente o Consulte con el Administrador",
                            color: "danger",
                            position: "top-right"
                        });
                    }
                });
        },
        guardarCantidadEspecifica(valor) {
            let material = {
                descripcion_cantidad_especifica: valor
            };

            axios
                .post(this.localVal + "/api/Bodega/PostCantEsp", material, {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    if (res.data == true) {
                        this.$vs.notify({
                            time: 3000,
                            title: "Cantidad Especifica Agregada Correctamente",
                            text: "Se Recargara Listado",
                            color: "success",
                            position: "top-right"
                        });
                        this.cargarCantidadEspecifica();
                        this.seleccionCantEsp = {
                            id: 0,
                            descripcion_cantidad_especifica:
                                "Seleccione Cantidad Especifica"
                        };
                        this.popActiveCantidadEsp = false;
                    } else {
                        this.$vs.notify({
                            time: 3000,
                            title: "Error Al Guardar Material",
                            text:
                                "Intente Nuevamente o Consulte con el Administrador",
                            color: "danger",
                            position: "top-right"
                        });
                    }
                });
        },
        CalcTotal() {
            try {
                if (
                    this.seleccionMaterial.id == 0 ||
                    this.seleccionMaterial.id == null
                ) {
                    this.$vs.notify({
                        time: 3000,
                        title: "Error ",
                        text:
                            "Debe Seleccionar Algun Material para calcular la cantidad",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.seleccionTipoMaterial.id == 0 ||
                    this.seleccionTipoMaterial.id == null
                ) {
                    this.$vs.notify({
                        time: 3000,
                        title: "Error ",
                        text:
                            "Debe Seleccionar el Tipo de Material para calcular la cantidad",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.seleccionCantEsp.id == 0 ||
                    this.seleccionCantEsp.id == null
                ) {
                    this.$vs.notify({
                        time: 3000,
                        title: "Error ",
                        text: "Debe Seleccionar Algun Contenido",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.seleccionMedidas.id == 0 ||
                    this.seleccionMedidas.id == null
                ) {
                    this.$vs.notify({
                        time: 3000,
                        title: "Error ",
                        text: "Alguna Medida",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    if (this.seleccionMedidas.id == 1) {
                        console.log("CC");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(
                                    Number.parseFloat(
                                        this.seleccionCantEsp
                                            .descripcion_cantidad_especifica
                                    )
                                )
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let val = Number.parseFloat(
                                    this.seleccionCantEsp
                                        .descripcion_cantidad_especifica
                                );
                                let res =
                                    (parseFloat(val) / 1000) * this.cantidad;

                                this.total = res.toFixed(2) + " Litros";
                                this.totalMaterial = res.toFixed(2);
                            }
                        } catch (error) {
                            console.log("Orror");
                            console.log(error);
                        }
                    } else if (this.seleccionMedidas.id == 2) {
                        console.log("MM");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(
                                    Number.parseFloat(
                                        this.seleccionCantEsp
                                            .descripcion_cantidad_especifica
                                    )
                                )
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let val = Number.parseFloat(
                                    this.seleccionCantEsp
                                        .descripcion_cantidad_especifica
                                );
                                let res =
                                    (parseFloat(val) / 1000) * this.cantidad;

                                this.total = res.toFixed(2) + " Metros";
                                this.totalMaterial = res.toFixed(2);
                            }
                        } catch (error) {
                            console.log("Orror");
                            console.log(error);
                        }
                    } else if (this.seleccionMedidas.id == 3) {
                        console.log("PULG");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(
                                    Number.parseFloat(
                                        this.seleccionCantEsp
                                            .descripcion_cantidad_especifica
                                    )
                                )
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let val = Number.parseFloat(
                                    this.seleccionCantEsp
                                        .descripcion_cantidad_especifica
                                );

                                let res =
                                    parseFloat(val) * 0.0254 * this.cantidad;

                                this.total = res.toFixed(2) + " Metros";
                                this.totalMaterial = res.toFixed(2);
                            }
                        } catch (error) {
                            console.log("Orror");
                            console.log(error);
                        }
                    } else if (this.seleccionMedidas.id == 4) {
                        console.log("CM");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(
                                    Number.parseFloat(
                                        this.seleccionCantEsp
                                            .descripcion_cantidad_especifica
                                    )
                                )
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let val = Number.parseFloat(
                                    this.seleccionCantEsp
                                        .descripcion_cantidad_especifica
                                );

                                let res =
                                    (parseFloat(val) / 100) * this.cantidad;

                                this.total = res.toFixed(2) + " Metros";
                                this.totalMaterial = res.toFixed(2);
                            }
                        } catch (error) {
                            console.log("Orror");
                            console.log(error);
                        }
                    } else if (this.seleccionMedidas.id == 5) {
                        console.log("KG");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(
                                    Number.parseFloat(
                                        this.seleccionCantEsp
                                            .descripcion_cantidad_especifica
                                    )
                                )
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let val = Number.parseFloat(
                                    this.seleccionCantEsp
                                        .descripcion_cantidad_especifica
                                );

                                let res = parseFloat(val) * this.cantidad;

                                this.total = res.toFixed(2) + " Kilos";
                                this.totalMaterial = res.toFixed(2);
                            }
                        } catch (error) {
                            console.log("Orror");
                            console.log(error);
                        }
                    } else if (this.seleccionMedidas.id == 6) {
                        console.log("GR");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(
                                    Number.parseFloat(
                                        this.seleccionCantEsp
                                            .descripcion_cantidad_especifica
                                    )
                                )
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let val = Number.parseFloat(
                                    this.seleccionCantEsp
                                        .descripcion_cantidad_especifica
                                );

                                let res =
                                    (parseFloat(val) / 1000) * this.cantidad;

                                this.total =
                                    res.toFixed(2).toFixed(2) + " Kilos";
                                this.totalMaterial = res.toFixed(2);
                            }
                        } catch (error) {
                            console.log("Orror");
                            console.log(error);
                        }
                    } else if (this.seleccionMedidas.id == 7) {
                        console.log("ROLLO");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(
                                    Number.parseFloat(
                                        this.seleccionCantEsp
                                            .descripcion_cantidad_especifica
                                    )
                                )
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let val = Number.parseFloat(
                                    this.seleccionCantEsp
                                        .descripcion_cantidad_especifica
                                );
                                let res = parseFloat(val) * this.cantidad;

                                this.total = res.toFixed(2) + " Metros";
                                this.totalMaterial = res.toFixed(2);
                            }
                        } catch (error) {
                            console.log("Orror");
                            console.log(error);
                        }
                    } else if (this.seleccionMedidas.id == 8) {
                        console.log("UN");
                        this.total = this.cantidad + " Unidades";
                        this.totalMaterial = parseFloat(this.cantidad).toFixed(
                            2
                        );
                    } else if (this.seleccionMedidas.id == 9) {
                        console.log("TIRA");
                        let res = this.cantidad * 6;
                        this.total = res + " Metros";
                        this.totalMaterial = this.res.toFixed(2);
                    } else if (this.seleccionMedidas.id == 10) {
                        console.log("SACO");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(
                                    Number.parseFloat(
                                        this.seleccionCantEsp
                                            .descripcion_cantidad_especifica
                                    )
                                )
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let val = Number.parseFloat(
                                    this.seleccionCantEsp
                                        .descripcion_cantidad_especifica
                                );

                                let res = parseFloat(val) * this.cantidad;

                                this.total = res.toFixed(2) + " Kilos";
                                this.totalMaterial = res.toFixed(2);
                            }
                        } catch (error) {
                            console.log("Orror");
                            console.log(error);
                        }
                    } else if (this.seleccionMedidas.id == 11) {
                        console.log("ML");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(
                                    Number.parseFloat(
                                        this.seleccionCantEsp
                                            .descripcion_cantidad_especifica
                                    )
                                )
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let val = Number.parseFloat(
                                    this.seleccionCantEsp
                                        .descripcion_cantidad_especifica
                                );

                                let res =
                                    (parseFloat(val) / 1000) * this.cantidad;

                                this.total = res.toFixed(2) + " Litros";
                                this.totalMaterial = res.toFixed(2);
                            }
                        } catch (error) {
                            console.log("Orror");
                            console.log(error);
                        }
                    } else if (this.seleccionMedidas.id == 12) {
                        console.log("M2");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(
                                    Number.parseFloat(
                                        this.seleccionCantEsp
                                            .descripcion_cantidad_especifica
                                    )
                                )
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let val = Number.parseFloat(
                                    this.seleccionCantEsp
                                        .descripcion_cantidad_especifica
                                );

                                let res =
                                    parseFloat(val) * 0.0254 * this.cantidad;
                                res = res.toFixed(2);
                                this.total = res.toFixed(2);
                            }
                        } catch (error) {
                            console.log("Orror");
                            console.log(error);
                        }
                    } else if (this.seleccionMedidas.id == 13) {
                        console.log("M3");
                    } else if (this.seleccionMedidas.id == 14) {
                        console.log("LT");

                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(
                                    Number.parseFloat(
                                        this.seleccionCantEsp
                                            .descripcion_cantidad_especifica
                                    )
                                )
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let val = Number.parseFloat(
                                    this.seleccionCantEsp
                                        .descripcion_cantidad_especifica
                                );

                                let res = parseFloat(val) * this.cantidad;

                                this.total = res.toFixed(2) + " Litros";
                                this.totalMaterial = res.toFixed(2);
                            }
                        } catch (error) {
                            console.log("Orror");
                            console.log(error);
                        }
                    } else if (this.seleccionMedidas.id == 15) {
                        console.log("TAMBOR");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(
                                    Number.parseFloat(
                                        this.seleccionCantEsp
                                            .descripcion_cantidad_especifica
                                    )
                                )
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let val = Number.parseFloat(
                                    this.seleccionCantEsp
                                        .descripcion_cantidad_especifica
                                );

                                let res = parseFloat(val) * this.cantidad;

                                this.total = res.toFixed(2) + " Litros";
                                this.totalMaterial = res.toFixed(2);
                            }
                        } catch (error) {
                            console.log("Orror");
                            console.log(error);
                        }
                    } else if (this.seleccionMedidas.id == 16) {
                        console.log("BOLSA");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(
                                    Number.parseFloat(
                                        this.seleccionCantEsp
                                            .descripcion_cantidad_especifica
                                    )
                                )
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let val = Number.parseFloat(
                                    this.seleccionCantEsp
                                        .descripcion_cantidad_especifica
                                );

                                let res = parseFloat(val) * this.cantidad;

                                this.total = res.toFixed(2) + " Kilos";
                                this.totalMaterial = res.toFixed(2);
                            }
                        } catch (error) {
                            console.log("Orror");
                            console.log(error);
                        }
                    } else if (this.seleccionMedidas.id == 17) {
                        console.log("GALON");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);

                            let res = this.cantidad * 3.78541;

                            this.total = res.toFixed(2) + " Litros";
                            this.totalMaterial = res.toFixed(2);
                        } catch (error) {
                            console.log("Orror");
                            console.log(error);
                        }
                    } else if (this.seleccionMedidas.id == 18) {
                        console.log("CAJA");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(
                                    Number.parseFloat(
                                        this.seleccionCantEsp
                                            .descripcion_cantidad_especifica
                                    )
                                )
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let val = Number.parseFloat(
                                    this.seleccionCantEsp
                                        .descripcion_cantidad_especifica
                                );

                                let res = parseFloat(val) * this.cantidad;

                                this.total = res.toFixed(2) + " Unidades";
                                this.totalMaterial = res.toFixed(2);
                            }
                        } catch (error) {
                            console.log("Orror");
                            console.log(error);
                        }
                    } else if (this.seleccionMedidas.id == 20) {
                        console.log("PLANCHA");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(
                                    Number.parseFloat(
                                        this.seleccionCantEsp
                                            .descripcion_cantidad_especifica
                                    )
                                )
                            ) {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error ",
                                    text:
                                        "Debe seleccionar o ingresar un numero en el contenido",
                                    color: "danger",
                                    position: "top-right"
                                });
                                this.total = 0;
                            } else {
                                let val = Number.parseFloat(
                                    this.seleccionCantEsp
                                        .descripcion_cantidad_especifica
                                );

                                let res = parseFloat(val) * this.cantidad;

                                this.total = res.toFixed(2) + " Metros";
                                this.totalMaterial = res.toFixed(2);
                            }
                        } catch (error) {
                            console.log("Orror");
                            console.log(error);
                        }
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },
        cargarMaterialEspecifico() {
            let id = this.$route.params.id;
            axios
                .get(this.localVal + `/api/Bodega/TraerMaterial/${id}`, {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    let data = res.data;
                    this.cargarDataEspecifica(data);
                })
                .catch(error => console.log(error));
        },
        valorTotal() {
            let total = this.valor * this.cantidad;
            this.totalValor = total;
        },
        cargarDataEspecifica(listado) {
            console.log(listado);
            var idGen = listado[0].id_ubicaciones;
            let c = this.listadoUbicacionData;
            let b = [];
            let a = 0;
            c.forEach((value, index) => {
                a = value.id;
                if (a == idGen) {
                    b.push(value);
                }
            });
            this.seleccionUbicacion.id = b[0].id;
            this.seleccionUbicacion.descripcion_ubicacion =
                b[0].descripcion_ubicacion;

            idGen = listado[0].id_servicios;
            c = this.listadoServicioData;
            b = [];
            a = 0;
            c.forEach((value, index) => {
                a = value.id;
                if (a == idGen) {
                    b.push(value);
                }
            });
            this.seleccionServicio.id = b[0].id;
            this.seleccionServicio.descripcion_servicio =
                b[0].descripcion_servicio;

            idGen = listado[0].id_material_ing;
            c = this.listadoMaterialData;
            b = [];
            a = 0;
            c.forEach((value, index) => {
                a = value.id;
                if (a == idGen) {
                    b.push(value);
                }
            });
            this.seleccionMaterial.id = b[0].id_material_ing;
            this.seleccionMaterial.id = b[0].descripcion_material;

            idGen = listado[0].id_material_tipo;
            c = this.listadoTipoMaterialData;
            b = [];
            a = 0;
            c.forEach((value, index) => {
                a = value.id;
                if (a == idGen) {
                    b.push(value);
                }
            });
            this.seleccionTipoMaterial.id = b[0].id;
            this.seleccionTipoMaterial.descripcion_tipo_material =
                b[0].descripcion_tipo_material;

            idGen = listado[0].id_cant_esp;
            c = this.listadoCantEspData;
            b = [];
            a = 0;
            c.forEach((value, index) => {
                a = value.id;
                if (a == idGen) {
                    b.push(value);
                }
            });
            this.seleccionCantEsp.id = b[0].id;
            this.seleccionCantEsp.descripcion_cantidad_especifica =
                b[0].descripcion_cantidad_especifica;

            idGen = listado[0].id_material_medida;
            c = this.listadoMedidasData;
            b = [];
            a = 0;
            c.forEach((value, index) => {
                a = value.id;
                if (a == idGen) {
                    b.push(value);
                }
            });
            this.seleccionMedidas.id = b[0].id;
            this.seleccionMedidas.descripcion_medidas =
                b[0].descripcion_medidas;

            this.cantidad = listado[0].material_cantidad;
            this.valor = listado[0].material_valor;
            this.ndocumento = listado[0].n_documento;

            idGen = listado[0].id_documento;
            c = this.listadoDocumentoAsociado;
            b = [];
            a = 0;
            c.forEach((value, index) => {
                a = value.id;
                if (a == idGen) {
                    b.push(value);
                }
            });
            this.seleccionDocumento.id = b[0].id;
            this.seleccionDocumento.descripcion_documento =
                b[0].descripcion_documento;
        }
    },
    created() {
        this.cargarUbicaciones();
        this.cargarServicios();
        this.cargarMedidas();
        this.cargarMaterial();
        this.cargarTipoMaterial();
        this.cargarCantidadEspecifica();
        this.cargarDocumentoAsociado();
        this.cargarMaterialEspecifico();
    }
};
</script>
