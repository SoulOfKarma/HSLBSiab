<template>
    <div>
        <vs-row>
            <div
                class="router-header flex flex-wrap items-center mb-8"
                style="margin-left:10px;"
            >
                <div
                    class="content-area__heading pr-4 border-0 md:border-r border-solid border-grey-light"
                >
                    <h2 class="mb-1">Ingreso de Material Nuevo</h2>
                </div>
                <div class="vx-breadcrumb ml-4 md:block hidden">
                    <div
                        class="content-area__heading pr-4 border-0 md:border-r border-solid border-grey-light"
                    >
                        <h3 class="mb-1">
                            Agente:
                            <p>{{ nombre }} - {{ run }}</p>
                        </h3>
                    </div>
                </div>
            </div>
            <vs-alert
                color="primary"
                icon="new_releases"
                active="true"
                style="margin-bottom: 10px;"
            >
                <p>Recuerda que todos los campos son obligatorios!</p>
            </vs-alert>
            <!-- Ubicacion -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="1. Ingreso de Material Nuevo">
                    <div class="vx-row mb-4">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.1 Seleccione Ubicacion</h6>
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
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.2 Seleccione Servicio</h6>
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
                        </div>
                    </div>
                    <div class="vx-row mb-4">
                        <div class="vx-col w-1/3 mt-5">
                            <h6>1.3 Seleccione Material a Ingresar</h6>
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
                        </div>
                        <div class="vx-col w-1/3 mt-5">
                            <h6>1.4 Seleccione Tipo de Material</h6>
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
                        </div>
                        <div class="vx-col w-1/6 mt-5">
                            <h6>1.5 Ingrese Contenido</h6>
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
                        </div>
                        <div class="vx-col w-1/8 mt-5">
                            <h6>Tipo Medida</h6>
                            <br />
                            <v-select
                                v-model="seleccionMedidas"
                                placeholder="Medidas"
                                class="w-full select-large"
                                label="descripcion_medidas"
                                :options="listadoMedidas"
                            />
                        </div>
                    </div>
                    <div class="vx-row mb-4">
                        <div class="vx-col w-1/3 mt-5">
                            <h6>1.6 Ingrese Cantidad</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                v-model="cantidad"
                                @input="CalcTotal"
                                :step="0.5"
                                @keypress="isNumber($event)"
                            />
                        </div>
                        <div class="vx-col w-1/8 mt-5">
                            <h6>Total Segun Medida.</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                v-model="total"
                                :step="0.5"
                            />
                        </div>
                        <div class="vx-col w-1/3 mt-5">
                            <h6>1.7 Ingrese Valor del Material</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                v-model="valor"
                                @input="valorTotal"
                                :step="0.5"
                                @keypress="isNumber($event)"
                            ></vs-input>
                        </div>
                        <div class="vx-col w-1/8 mt-5">
                            <h6>Total Valor.</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                v-model="totalValor"
                                :step="0.5"
                            />
                        </div>
                    </div>
                    <div class="vx-row mb-4">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.8 Seleccione Tipo Documento</h6>
                            <br />
                            <v-select
                                v-model="seleccionDocumento"
                                placeholder="Documento"
                                class="w-full select-large"
                                label="descripcion_documento"
                                :options="listadoDocumentoAsociado"
                            ></v-select>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.9 Ingrese N° Documento</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                v-model="ndocumento"
                            ></vs-input>
                        </div>
                    </div>
                    <div class="vx-row mb-4">
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                class="fixedHeight w-full"
                                @click="volver"
                                color="primary"
                                >Volver</vs-button
                            >
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                class="fixedHeight w-full"
                                @click="guardarMaterialNuevo"
                                color="success"
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

Vue.use(Vuesax, {
    theme: {
        colors: {
            primary: "#5b3cc4",
            success: "rgb(23, 201, 100)",
            danger: "rgb(242, 19, 93)",
            warning: "rgb(255, 130, 0)",
            dark: "rgb(36, 33, 69)"
        }
    }
});
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
    data() {
        return {
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
            nombre:
                sessionStorage.getItem("nombre") +
                " " +
                sessionStorage.getItem("apellido"),
            run: sessionStorage.getItem("run"),
            localVal: process.env.MIX_APP_URL,
            popActiveMaterial: false,
            popActiveTMaterial: false,
            popActiveCantidadEsp: false
        };
    },
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
        guardarMaterialNuevo() {
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
                        text: "Debe seleccionar Alguna Medida",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.seleccionUbicacion.id == 0 ||
                    this.seleccionUbicacion.id == null
                ) {
                    this.$vs.notify({
                        time: 3000,
                        title: "Error ",
                        text: "Debe seleccionar alguna ubicacion",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.seleccionServicio.id == 0 ||
                    this.seleccionServicio.id == null
                ) {
                    this.$vs.notify({
                        time: 3000,
                        title: "Error ",
                        text: "Debe seleccionar algun servicio",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        id_ubicaciones: this.seleccionUbicacion.id,
                        id_servicios: this.seleccionServicio.id,
                        id_material_ing: this.seleccionMaterial.id,
                        id_material_tipo: this.seleccionTipoMaterial.id,
                        id_cant_esp: this.seleccionCantEsp.id,
                        id_material_medida: this.seleccionMedidas.id,
                        material_cantidad: this.cantidad,
                        material_valor: this.valor,
                        material_cantidad_calculada: this.totalMaterial,
                        id_documento: this.seleccionDocumento.id,
                        n_documento: this.ndocumento
                    };

                    const inventario = data;

                    axios
                        .post(
                            this.localVal + "/api/Bodega/PostInventario",
                            inventario,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            if (res.data == true) {
                                this.$vs.notify({
                                    time: 3000,
                                    title:
                                        "Inventario Registrado Correctamente",
                                    text: "Se vaciaran campos",
                                    color: "success",
                                    position: "top-right"
                                });
                            } else {
                                this.$vs.notify({
                                    time: 3000,
                                    title: "Error Al Guardar Inventario",
                                    text:
                                        "Intente Nuevamente o Consulte con el Administrador",
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
        volver() {
            router.back();
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
                        try {
                            console.log("TIRA");
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);
                            if (
                                Number.isNaN(
                                    Number.parseFloat(
                                        this.seleccionCantEsp
                                            .descripcion_cantidad_especifica
                                    )
                                )
                            ) {
                                let res = this.cantidad * 6;
                                this.total = res + " Metros";
                                this.totalMaterial = this.res.toFixed(2);
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

                                this.total = res + " Unidades";
                                this.totalMaterial = res;
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
                    } else if (this.seleccionMedidas.id == 21) {
                        console.log("METRO");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);

                            let val = Number.parseFloat(
                                this.seleccionCantEsp
                                    .descripcion_cantidad_especifica
                            );

                            this.total = this.cantidad + " Metros";
                            this.totalMaterial = parseFloat(
                                this.cantidad
                            ).toFixed(2);
                        } catch (error) {
                            console.log("Orror");
                            console.log(error);
                        }
                    } else if (this.seleccionMedidas.id == 22) {
                        console.log("PAR");
                        try {
                            //let val = parseFloat(this.seleccionCantEsp.descripcion_cantidad_especifica);

                            let val = Number.parseFloat(
                                this.seleccionCantEsp
                                    .descripcion_cantidad_especifica
                            );

                            this.total = this.cantidad + " Pares";
                            this.totalMaterial = parseFloat(
                                this.cantidad
                            ).toFixed(2);
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
        valorTotal() {
            let total = this.valor * this.cantidad;
            this.totalValor = total;
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
    }
};
</script>
