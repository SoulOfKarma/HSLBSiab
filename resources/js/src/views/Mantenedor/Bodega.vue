<template>
    <div>
        <vx-card title="Bodega y Familias Asociadas">
            <vx-card title="">
                <div class="vx-row w-full ">
                    <div class="vx-col w-1/2 mt-5">
                        <vs-button
                            color="primary"
                            type="filled"
                            @click="popUpBodega = true"
                            >Agregar y Modificar Bodega</vs-button
                        >
                    </div>
                    <br />
                    <div class="vx-col w-1/2 mt-5">
                        <vs-button
                            color="primary"
                            type="filled"
                            @click="popUpFam1 = true"
                            >Agregar y Modificar Familia 1</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <vs-button
                            color="primary"
                            type="filled"
                            @click="popUpFam2 = true"
                            >Agregar y Modificar Familia 2</vs-button
                        >
                    </div>
                    <br />
                    <div class="vx-col w-1/2 mt-5">
                        <vs-button
                            color="primary"
                            type="filled"
                            @click="popUpFam3 = true"
                            >Agregar y Modificar Familia 3</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <vs-button
                            color="primary"
                            type="filled"
                            @click="popUpFam4 = true"
                            >Agregar y Modificar Familia 4</vs-button
                        >
                    </div>
                    <br />
                    <div class="vx-col w-1/2 mt-5">
                        <vs-button
                            color="primary"
                            type="filled"
                            @click="popUpFam5 = true"
                            >Agregar y Modificar Familia 5</vs-button
                        >
                    </div>
                </div>
            </vx-card>
            <br />
            <div class="vx-col md:w-1/1 w-full mb-base">
                <!-- Bodega -->
                <vs-popup
                    classContent="AM Bodega"
                    title="Agregar y Modificar Bodega"
                    :active.sync="popUpBodega"
                >
                    <div class="vx-row w-full">
                        <div class="vx-col w-1/2 mt-5">
                            <vx-card title="Agregar Bodega">
                                <vs-input
                                    class="w-full inputx"
                                    placeholder="Descripcion Bodega"
                                    v-model="descripcionBodega"
                                />
                                <br />
                                <vs-button
                                    color="success"
                                    type="filled"
                                    @click="AgregarBodega"
                                    >Agregar</vs-button
                                >
                            </vx-card>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vx-card title="Modificar Bodega">
                                <v-select
                                    v-model="seleccionBodega"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionBodega"
                                    :options="listaBodega"
                                    @input="cargaItemBodega"
                                ></v-select>
                                <br />
                                <vs-input
                                    class="inputx w-full"
                                    placeholder="Modificar Bodega Seleccionada"
                                    v-model="descripcionBodegaMod"
                                />
                                <br />
                                <vs-button
                                    color="warning"
                                    type="filled"
                                    @click="ModificarBodega"
                                    >Modificar</vs-button
                                >
                            </vx-card>
                        </div>
                    </div>
                </vs-popup>
                <!-- Familia 1 -->
                <vs-popup
                    classContent="AMFam2"
                    title="Agregar y Modificar Familia 1"
                    :active.sync="popUpFam1"
                >
                    <div class="vx-row w-full">
                        <div class="vx-col w-1/2 mt-5">
                            <vx-card title="Agregar Familia 1">
                                <v-select
                                    v-model="seleccionBodega"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionBodega"
                                    :options="listaBodega"
                                ></v-select>
                                <br />
                                <vs-input
                                    class="w-full inputx"
                                    placeholder="Descripcion Familia 1"
                                    v-model="descripcionFamilia1"
                                />
                                <br />
                                <vs-button
                                    color="success"
                                    type="filled"
                                    @click="AgregarFamilia1"
                                    >Agregar</vs-button
                                >
                            </vx-card>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vx-card title="Modificar Familia 1">
                                <v-select
                                    v-model="seleccionBodegaMod"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionBodega"
                                    :options="listaBodega"
                                    @input="cargaItemBodegaFamiliaMod"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia1M"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia1"
                                    @input="cargaItemFamiliaDescripcion1"
                                ></v-select>
                                <br />
                                <vs-input
                                    class="inputx w-full"
                                    placeholder="Modificar Familia 1 Seleccionada"
                                    v-model="descripcionFamilia1Mod"
                                />
                                <br />
                                <vs-button
                                    color="warning"
                                    type="filled"
                                    @click="ModificarFamilia1"
                                    >Modificar</vs-button
                                >
                            </vx-card>
                        </div>
                    </div>
                </vs-popup>
                <!-- Familia 2 -->
                <vs-popup
                    classContent="AMFamilia2"
                    title="Agregar y Modificar Familia 2"
                    :active.sync="popUpFam2"
                >
                    <div class="vx-row w-full">
                        <div class="vx-col w-1/2 mt-5">
                            <vx-card title="Agregar Familia 2">
                                <v-select
                                    v-model="seleccionBodega"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionBodega"
                                    :options="listaBodega"
                                    @input="cargaItemBodegaFamilia"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia1"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia1"
                                ></v-select>
                                <br />
                                <vs-input
                                    class="w-full inputx"
                                    placeholder="Descripcion Familia 2"
                                    v-model="descripcionFamilia2"
                                />
                                <br />
                                <vs-button
                                    color="success"
                                    type="filled"
                                    @click="AgregarFamilia2"
                                    >Agregar</vs-button
                                >
                            </vx-card>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vx-card title="Modificar Familia 2">
                                <v-select
                                    v-model="seleccionBodegaMod"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionBodega"
                                    :options="listaBodega"
                                    @input="cargaItemBodegaFamiliaMod"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia1M"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia1"
                                    @input="cargaItemFamilia1M"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia2M"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia2"
                                    @input="cargaItemFamiliaDescripcion2"
                                ></v-select>
                                <br />
                                <vs-input
                                    class="inputx w-full"
                                    placeholder="Modificar Familia 2 Seleccionada"
                                    v-model="descripcionFamilia2Mod"
                                />
                                <br />
                                <vs-button
                                    color="warning"
                                    type="filled"
                                    @click="ModificarFamilia2"
                                    >Modificar</vs-button
                                >
                            </vx-card>
                        </div>
                    </div>
                </vs-popup>
                <!-- Familia 3 -->
                <vs-popup
                    classContent="AMFamilia2"
                    title="Agregar y Modificar Familia 3"
                    :active.sync="popUpFam3"
                >
                    <div class="vx-row w-full">
                        <div class="vx-col w-1/2 mt-5">
                            <vx-card title="Agregar Familia 3">
                                <v-select
                                    v-model="seleccionBodega"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionBodega"
                                    :options="listaBodega"
                                    @input="cargaItemBodegaFamilia"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia1"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia1"
                                    @input="cargaItemFamilia1"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia2"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia2"
                                    @input="cargaItemFamilia2"
                                ></v-select>
                                <br />
                                <vs-input
                                    class="w-full inputx"
                                    placeholder="Descripcion Familia 3"
                                    v-model="descripcionFamilia3"
                                />
                                <br />
                                <vs-button
                                    color="success"
                                    type="filled"
                                    @click="AgregarFamilia3"
                                    >Agregar</vs-button
                                >
                            </vx-card>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vx-card title="Modificar Familia 3">
                                <v-select
                                    v-model="seleccionBodegaMod"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionBodega"
                                    :options="listaBodega"
                                    @input="cargaItemBodegaFamiliaMod"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia1M"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia1"
                                    @input="cargaItemFamilia1M"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia2M"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia2"
                                    @input="cargaItemFamilia2M"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia3M"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia3"
                                    @input="cargaItemFamiliaDescripcion3"
                                ></v-select>
                                <br />
                                <vs-input
                                    class="inputx w-full"
                                    placeholder="Modificar Familia 3 Seleccionada"
                                    v-model="descripcionFamilia3Mod"
                                />
                                <br />
                                <vs-button
                                    color="warning"
                                    type="filled"
                                    @click="ModificarFamilia3"
                                    >Modificar</vs-button
                                >
                            </vx-card>
                        </div>
                    </div>
                </vs-popup>
                <!-- Familia 4 -->
                <vs-popup
                    classContent="AMFamilia2"
                    title="Agregar y Modificar Familia 4"
                    :active.sync="popUpFam4"
                >
                    <div class="vx-row w-full">
                        <div class="vx-col w-1/2 mt-5">
                            <vx-card title="Agregar Familia 4">
                                <v-select
                                    v-model="seleccionBodega"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionBodega"
                                    :options="listaBodega"
                                    @input="cargaItemBodegaFamilia"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia1"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia1"
                                    @input="cargaItemFamilia1"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia2"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia2"
                                    @input="cargaItemFamilia2"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia3"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia3"
                                ></v-select>
                                <br />
                                <vs-input
                                    class="w-full inputx"
                                    placeholder="Descripcion Familia 4"
                                    v-model="descripcionFamilia4"
                                />
                                <br />
                                <vs-button
                                    color="success"
                                    type="filled"
                                    @click="AgregarFamilia4"
                                    >Agregar</vs-button
                                >
                            </vx-card>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vx-card title="Modificar Familia 4">
                                <v-select
                                    v-model="seleccionBodegaMod"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionBodega"
                                    :options="listaBodega"
                                    @input="cargaItemBodegaFamiliaMod"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia1M"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia1"
                                    @input="cargaItemFamilia1M"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia2M"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia2"
                                    @input="cargaItemFamilia2M"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia3M"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia3"
                                    @input="cargaItemFamilia3M"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia4M"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia4"
                                    @input="cargaItemFamiliaDescripcion4"
                                ></v-select>
                                <br />
                                <vs-input
                                    class="inputx w-full"
                                    placeholder="Modificar Familia 4 Seleccionada"
                                    v-model="descripcionFamilia4Mod"
                                />
                                <br />
                                <vs-button
                                    color="warning"
                                    type="filled"
                                    @click="ModificarFamilia4"
                                    >Modificar</vs-button
                                >
                            </vx-card>
                        </div>
                    </div>
                </vs-popup>
                <!-- Familia 5 -->
                <vs-popup
                    classContent="AMFamilia5"
                    title="Agregar y Modificar Familia 5"
                    :active.sync="popUpFam5"
                >
                    <div class="vx-row w-full">
                        <div class="vx-col w-1/2 mt-5">
                            <vx-card title="Agregar Familia 5">
                                <v-select
                                    v-model="seleccionBodega"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionBodega"
                                    :options="listaBodega"
                                    @input="cargaItemBodegaFamilia"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia1"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia1"
                                    @input="cargaItemFamilia1"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia2"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia2"
                                    @input="cargaItemFamilia2"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia3"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia3"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia4"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia4"
                                ></v-select>
                                <br />
                                <vs-input
                                    class="w-full inputx"
                                    placeholder="Descripcion Familia 5"
                                    v-model="descripcionFamilia5"
                                />
                                <br />
                                <vs-button
                                    color="success"
                                    type="filled"
                                    @click="AgregarFamilia5"
                                    >Agregar</vs-button
                                >
                            </vx-card>
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vx-card title="Modificar Familia 5">
                                <v-select
                                    v-model="seleccionBodegaMod"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionBodega"
                                    :options="listaBodega"
                                    @input="cargaItemBodegaFamiliaMod"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia1M"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia1"
                                    @input="cargaItemFamilia1M"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia2M"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia2"
                                    @input="cargaItemFamilia2M"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia3M"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia3"
                                    @input="cargaItemFamilia3M"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia4M"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia4"
                                    @input="cargaItemFamilia4M"
                                ></v-select>
                                <br />
                                <v-select
                                    v-model="seleccionFamilia5M"
                                    placeholder="Bodega"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia5"
                                    @input="cargaItemFamiliaDescripcion5"
                                ></v-select>
                                <br />
                                <vs-input
                                    class="inputx w-full"
                                    placeholder="Modificar Familia 5 Seleccionada"
                                    v-model="descripcionFamilia5Mod"
                                />
                                <br />
                                <vs-button
                                    color="warning"
                                    type="filled"
                                    @click="ModificarFamilia5"
                                    >Modificar</vs-button
                                >
                            </vx-card>
                        </div>
                    </div>
                </vs-popup>
            </div>
        </vx-card>
    </div>
</template>
<script>
import axios from "axios";
import vSelect from "vue-select";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import { PlusCircleIcon } from "vue-feather-icons";
import Vue from "vue";
import VueTippy, { TippyComponent } from "vue-tippy";
Vue.use(VueTippy);
Vue.component("tippy", TippyComponent);

export default {
    components: {
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
            popUpBodega: false,
            popUpFam1: false,
            popUpFam2: false,
            popUpFam3: false,
            popUpFam4: false,
            popUpFam5: false,
            descripcionBodega: "",
            descripcionBodegaMod: "",
            descripcionFamilia1: "",
            descripcionFamilia2: "",
            descripcionFamilia3: "",
            descripcionFamilia4: "",
            descripcionFamilia5: "",
            descripcionFamilia1Mod: "",
            descripcionFamilia2Mod: "",
            descripcionFamilia3Mod: "",
            descripcionFamilia4Mod: "",
            descripcionFamilia5Mod: "",
            idMod: 0,
            seleccionBodega: {
                id: 0,
                descripcionBodega: ""
            },
            seleccionBodegaMod: {
                id: 0,
                descripcionBodega: ""
            },
            seleccionFamilia1: {
                id: 0,
                descripcionFamilia: "",
                idBodega: 0
            },
            seleccionFamilia2: {
                id: 0,
                descripcionFamilia: "",
                idDesFam: 0
            },
            seleccionFamilia3: {
                id: 0,
                descripcionFamilia: "",
                idDesFam01: 0
            },
            seleccionFamilia4: {
                id: 0,
                descripcionFamilia: "",
                idDesFam02: 0
            },
            seleccionFamilia5: {
                id: 0,
                descripcionFamilia: "",
                idDesFam03: 0
            },
            seleccionFamilia1M: {
                id: 0,
                descripcionFamilia: "",
                idBodega: 0
            },
            seleccionFamilia2M: {
                id: 0,
                descripcionFamilia: "",
                idDesFam: 0
            },
            seleccionFamilia3M: {
                id: 0,
                descripcionFamilia: "",
                idDesFam01: 0
            },
            seleccionFamilia4M: {
                id: 0,
                descripcionFamilia: "",
                idDesFam02: 0
            },
            seleccionFamilia5M: {
                id: 0,
                descripcionFamilia: "",
                idDesFam03: 0
            },
            //Listados Bodega y Familias
            listaBodega: [],
            listaFamilia1: [],
            listaFamilia2: [],
            listaFamilia3: [],
            listaFamilia4: [],
            listaFamilia5: [],
            listaTempFamilia1: [],
            listaTempFamilia2: [],
            listaTempFamilia3: [],
            listaTempFamilia4: [],
            listaTempFamilia5: []
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
                this.descripcionBodega = "";
                this.descripcionBodegaMod = "";
                this.idMod = 0;
            } catch (error) {
                console.log(error);
            }
        },
        //Datos Carga a Modificar
        cargaItemBodega() {
            try {
                let c = this.listaBodega;
                let b = this.seleccionBodega.id;
                c.forEach((value, index) => {
                    if (b == value.id) {
                        this.descripcionBodegaMod = value.descripcionBodega;
                        this.idMod = value.id;
                    }
                });
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemBodegaFamilia() {
            try {
                this.listaFamilia1 = [];
                let c = this.listaTempFamilia1;
                let b = this.seleccionBodega.id;
                let a = [];
                c.forEach((value, index) => {
                    if (b == value.id) {
                        a.push(value);
                    }
                });

                this.listaFamilia1 = a;
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemBodegaFamiliaMod() {
            try {
                this.listaFamilia1 = [];
                let c = this.listaTempFamilia1;
                let b = this.seleccionBodegaMod.id;
                let a = [];
                c.forEach((value, index) => {
                    if (b == value.id) {
                        a.push(value);
                    }
                });

                this.listaFamilia1 = a;
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemFamilia1() {
            try {
                this.listaFamilia2 = [];
                let c = this.listaTempFamilia2;
                let b = this.seleccionFamilia1.id;
                let a = [];
                c.forEach((value, index) => {
                    if (b == value.id) {
                        a.push(value);
                    }
                });

                this.listaFamilia2 = a;
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemFamilia1M() {
            try {
                this.listaFamilia2 = [];
                let c = this.listaTempFamilia2;
                let b = this.seleccionFamilia1M.id;
                let a = [];
                c.forEach((value, index) => {
                    if (b == value.id) {
                        a.push(value);
                    }
                });

                this.listaFamilia2 = a;
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemFamilia2() {
            try {
                this.listaFamilia3 = [];
                let c = this.listaTempFamilia3;
                let b = this.seleccionFamilia2.id;
                let a = [];
                c.forEach((value, index) => {
                    if (b == value.id) {
                        a.push(value);
                    }
                });

                this.listaFamilia3 = a;
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemFamilia2M() {
            try {
                this.listaFamilia3 = [];
                let c = this.listaTempFamilia3;
                let b = this.seleccionFamilia2M.id;
                let a = [];
                c.forEach((value, index) => {
                    if (b == value.id) {
                        a.push(value);
                    }
                });

                this.listaFamilia3 = a;
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemFamilia3() {
            try {
                this.listaFamilia4 = [];
                let c = this.listaTempFamilia4;
                let b = this.seleccionFamilia3.id;
                let a = [];
                c.forEach((value, index) => {
                    if (b == value.id) {
                        a.push(value);
                    }
                });

                this.listaFamilia4 = a;
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemFamilia3M() {
            try {
                this.listaFamilia4 = [];
                let c = this.listaTempFamilia4;
                let b = this.seleccionFamilia3M.id;
                let a = [];
                c.forEach((value, index) => {
                    if (b == value.id) {
                        a.push(value);
                    }
                });

                this.listaFamilia4 = a;
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemFamilia4() {
            try {
                this.listaFamilia5 = [];
                let c = this.listaTempFamilia5;
                let b = this.seleccionFamilia4.id;
                let a = [];
                c.forEach((value, index) => {
                    if (b == value.id) {
                        a.push(value);
                    }
                });

                this.listaFamilia5 = a;
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemFamilia4M() {
            try {
                this.listaFamilia5 = [];
                let c = this.listaTempFamilia5;
                let b = this.seleccionFamilia4M.id;
                let a = [];
                c.forEach((value, index) => {
                    if (b == value.id) {
                        a.push(value);
                    }
                });

                this.listaFamilia5 = a;
            } catch (error) {
                console.log(error);
            }
        },
        //Carga de Descripciones a Modificar
        cargaItemFamiliaDescripcion1() {
            try {
                let c = this.listaFamilia1;
                let b = this.seleccionFamilia1M.id;
                c.forEach((value, index) => {
                    if (b == value.id) {
                        this.descripcionFamilia1Mod = value.descripcionFamilia;
                        this.idMod = value.id;
                    }
                });
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemFamiliaDescripcion2() {
            try {
                let c = this.listaFamilia2;
                let b = this.seleccionFamilia2M.id;
                c.forEach((value, index) => {
                    if (b == value.id) {
                        this.descripcionFamilia2Mod = value.descripcionFamilia;
                        this.idMod = value.id;
                    }
                });
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemFamiliaDescripcion3() {
            try {
                let c = this.listaFamilia3;
                let b = this.seleccionFamilia3M.id;
                c.forEach((value, index) => {
                    if (b == value.id) {
                        this.descripcionFamilia3Mod = value.descripcionFamilia;
                        this.idMod = value.id;
                    }
                });
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemFamiliaDescripcion4() {
            try {
                let c = this.listaFamilia4;
                let b = this.seleccionFamilia4M.id;
                c.forEach((value, index) => {
                    if (b == value.id) {
                        this.descripcionFamilia4Mod = value.descripcionFamilia;
                        this.idMod = value.id;
                    }
                });
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemFamiliaDescripcion5() {
            try {
                let c = this.listaFamilia5;
                let b = this.seleccionFamilia5M.id;
                c.forEach((value, index) => {
                    if (b == value.id) {
                        this.descripcionFamilia5Mod = value.descripcionFamilia;
                        this.idMod = value.id;
                    }
                });
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD Servicios
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
        TraerFamilia1() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetFamilia1", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaTempFamilia1 = res.data;
                        if (this.listaTempFamilia1.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de Familias Asociadas correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerFamilia2() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetFamilia2", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaTempFamilia2 = res.data;
                        if (this.listaTempFamilia2.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de Familias Asociadas correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerFamilia3() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetFamilia3", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaTempFamilia3 = res.data;
                        if (this.listaTempFamilia3.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de Familias Asociadas correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerFamilia4() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetFamilia4", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaTempFamilia4 = res.data;
                        if (this.listaTempFamilia4.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de Familias Asociadas correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerFamilia5() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetFamilia5", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaTempFamilia5 = res.data;
                        if (this.listaTempFamilia5.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de Familias Asociadas correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarBodega() {
            try {
                let data = {
                    descripcionBodega: this.descripcionBodega
                };

                const dat = data;

                axios
                    .post(this.localVal + "/api/Mantenedor/PostBodega", dat, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        const solicitudServer = res.data;
                        if (solicitudServer == true) {
                            this.limpiarCampos();
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text: "Bodega Ingresada Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.TraerBodega();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible registrar la Bodega,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        ModificarBodega() {
            try {
                let data = {
                    id: this.idMod,
                    descripcionBodega: this.descripcionBodegaMod
                };

                const dat = data;

                axios
                    .post(this.localVal + "/api/Mantenedor/PutBodega", dat, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        const solicitudServer = res.data;
                        if (solicitudServer == true) {
                            this.limpiarCampos();
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text: "Bodega Modificado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.seleccionBodega = {
                                id: data.id,
                                descripcionBodega: data.descripcionBodega
                            };
                            this.TraerBodega();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible modificar la Bodega,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarFamilia1() {
            try {
                let data = {
                    idBodega: this.seleccionBodega1.id,
                    descripcionFamilia: this.descripcionFamilia1
                };

                const dat = data;

                axios
                    .post(this.localVal + "/api/Mantenedor/PostFamilia1", dat, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        const solicitudServer = res.data;
                        if (solicitudServer == true) {
                            this.limpiarCampos();
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text: "Familia Ingresada Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.TraerFamilia1();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible registrar la Bodega,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        ModificarFamilia1() {
            try {
                let data = {
                    id: this.idMod,
                    idBodega: this.seleccionBodegaMod1.id,
                    descripcionFamilia: this.descripcionFamilia1Mod
                };

                const dat = data;

                axios
                    .post(this.localVal + "/api/Mantenedor/PutFamilia1", dat, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        const solicitudServer = res.data;
                        if (solicitudServer == true) {
                            this.limpiarCampos();
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text: "Bodega Modificado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.seleccionFamilia1 = {
                                id: data.id,
                                idBodega: data.idBodega,
                                descripcionFamilia: data.descripcionFamilia
                            };
                            this.TraerFamilia1();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible modificar la Bodega,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarFamilia2() {
            try {
                let data = {
                    idDesFam: this.seleccionFamilia1A.id,
                    descripcionFamilia: this.descripcionFamilia2
                };

                const dat = data;

                axios
                    .post(this.localVal + "/api/Mantenedor/PostFamilia2", dat, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        const solicitudServer = res.data;
                        if (solicitudServer == true) {
                            this.limpiarCampos();
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text: "Familia Ingresada Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.TraerFamilia2();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible registrar la Bodega,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        ModificarFamilia2() {
            try {
                let data = {
                    id: this.idMod,
                    idDesFam: this.seleccionFamilia2M.idDesFam,
                    descripcionFamilia: this.descripcionFamilia2Mod
                };

                const dat = data;

                axios
                    .post(this.localVal + "/api/Mantenedor/PutFamilia2", dat, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        const solicitudServer = res.data;
                        if (solicitudServer == true) {
                            this.limpiarCampos();
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text: "Bodega Modificado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.seleccionFamilia2 = {
                                id: data.id,
                                idDesFam: data.idDesFam,
                                descripcionFamilia: data.descripcionFamilia
                            };
                            this.TraerFamilia2();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible modificar la Bodega,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarFamilia3() {
            try {
                let data = {
                    idDesFam01: this.seleccionFamilia2.id,
                    descripcionFamilia: this.descripcionFamilia3
                };

                const dat = data;

                axios
                    .post(this.localVal + "/api/Mantenedor/PostFamilia3", dat, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        const solicitudServer = res.data;
                        if (solicitudServer == true) {
                            this.limpiarCampos();
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text: "Familia Ingresada Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.TraerFamilia3();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible registrar la Bodega,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        ModificarFamilia3() {
            try {
                let data = {
                    id: this.idMod,
                    idDesFam01: this.seleccionFamilia3M.id,
                    descripcionFamilia: this.descripcionFamilia3Mod
                };

                const dat = data;

                axios
                    .post(this.localVal + "/api/Mantenedor/PutFamilia3", dat, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        const solicitudServer = res.data;
                        if (solicitudServer == true) {
                            this.limpiarCampos();
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text: "Bodega Modificado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.seleccionFamilia3 = {
                                id: data.id,
                                idDesFam01: data.id,
                                descripcionFamilia: data.descripcionFamilia
                            };
                            this.TraerFamilia3();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible modificar la Bodega,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarFamilia4() {
            try {
                let data = {
                    idDesFam02: this.seleccionFamilia3.id,
                    descripcionFamilia: this.descripcionFamilia4
                };

                const dat = data;

                axios
                    .post(this.localVal + "/api/Mantenedor/PostFamilia4", dat, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        const solicitudServer = res.data;
                        if (solicitudServer == true) {
                            this.limpiarCampos();
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text: "Familia Ingresada Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.TraerFamilia4();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible registrar la Bodega,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        ModificarFamilia4() {
            try {
                let data = {
                    id: this.idMod,
                    idDesFam02: this.seleccionFamilia4M.id,
                    descripcionFamilia: this.descripcionFamilia4Mod
                };

                const dat = data;

                axios
                    .post(this.localVal + "/api/Mantenedor/PutFamilia4", dat, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        const solicitudServer = res.data;
                        if (solicitudServer == true) {
                            this.limpiarCampos();
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text: "Bodega Modificado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.seleccionFamilia4 = {
                                id: data.id,
                                idDesFam02: data.id,
                                descripcionFamilia: data.descripcionFamilia
                            };
                            this.TraerFamilia4();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible modificar la Bodega,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarFamilia5() {
            try {
                let data = {
                    idDesFam03: this.seleccionFamilia4.id,
                    descripcionFamilia: this.descripcionFamilia5
                };

                const dat = data;

                axios
                    .post(this.localVal + "/api/Mantenedor/PostFamilia5", dat, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        const solicitudServer = res.data;
                        if (solicitudServer == true) {
                            this.limpiarCampos();
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text: "Familia Ingresada Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.TraerFamilia5();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible registrar la Bodega,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        ModificarFamilia5() {
            try {
                let data = {
                    id: this.idMod,
                    idDesFam03: this.seleccionFamilia5M.id,
                    descripcionFamilia: this.descripcionFamilia5Mod
                };

                const dat = data;

                axios
                    .post(this.localVal + "/api/Mantenedor/PutFamilia5", dat, {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        const solicitudServer = res.data;
                        if (solicitudServer == true) {
                            this.limpiarCampos();
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text: "Bodega Modificado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.seleccionFamilia5 = {
                                id: data.id,
                                idDesFam: data.id,
                                descripcionFamilia: data.descripcionFamilia
                            };
                            this.TraerFamilia5();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible modificar la Bodega,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        }
    },
    beforeMount() {
        this.TraerBodega();
        this.TraerFamilia1();
        this.TraerFamilia2();
        this.TraerFamilia3();
        this.TraerFamilia4();
        this.TraerFamilia5();
        this.openLoadingColor();
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1000px;
}
</style>
