<template>
    <div>
        <vx-card title="Tipo Compra">
            <div>
                <vs-button color="primary" type="filled" @click="popTipoCompra"
                    >Tipo Compra</vs-button
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
                                    content="Modificar Tipo Compra"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popModificarTP(
                                            props.row.id,
                                            props.row.NOMTIPCOM,
                                            props.row.CATTIPCOM
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
                classContent="TipoCompra"
                title="Agregar Tipo Compra"
                :active.sync="popUpTP"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row ">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Nombre Tipo Compra</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    v-model="nomTipoCompra"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Categoria</h6>
                                <br />
                                <v-select
                                    v-model="seleccionTP"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionTP"
                                    :options="listaTipoCompra"
                                ></v-select>
                            </div>
                        </div>
                        <div class="vx-row w-full md-5">
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="popUpTP = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="AgregarTP"
                                    color="success"
                                    type="filled"
                                    class="w-full m-1"
                                    >Agregar Tipo Compra</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <vs-popup
                classContent="TPMod"
                title="Modificar Tipo Compra"
                :active.sync="popUpTPMod"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row ">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Nombre Tipo Compra</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    v-model="nomTipoCompra"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Categoria</h6>
                                <br />
                                <v-select
                                    v-model="seleccionTP"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionTP"
                                    :options="listaTipoCompra"
                                ></v-select>
                            </div>
                        </div>
                        <div class="vx-row w-full md-5">
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="popUpTPMod = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="ModificarTP"
                                    color="warning"
                                    type="filled"
                                    class="w-full m-1"
                                    >Modificar Tipo Compra</vs-button
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
            popUpTP: false,
            popUpTPMod: false,
            nomTipoCompra: "",
            idMod: 0,
            seleccionTP: {
                id: 1,
                descripcionTP: "RECEPCION"
            },
            //Template Columnas Listado Proveedor
            columns: [
                {
                    label: "Nombre Tipo Compra",
                    field: "NOMTIPCOM",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Categoria",
                    field: "CATTIPCOM",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ],
            //Datos Listado Proveedor
            rows: [],
            listaTipoCompra: [
                {
                    id: 1,
                    descripcionTP: "RECEPCION"
                },
                {
                    id: 2,
                    descripcionTP: "CONSUMO INMEDIATO"
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
                this.nomTipoCompra = "";
                this.seleccionTP = {
                    id: 1,
                    descripcionTP: "RECEPCION"
                };
                this.idMod = 0;
            } catch (error) {
                console.log(error);
            }
        },
        //PopUp
        popTipoCompra() {
            try {
                this.popUpTP = true;
            } catch (error) {
                console.log(error);
            }
        },
        popModificarTP(id, nomTipCom, catTipCom) {
            try {
                this.popUpTPMod = true;
                this.idMod = id;
                this.nomTipoCompra = nomTipCom;
                let c = this.listaTipoCompra;
                c.forEach((value, index) => {
                    if (catTipCom == value.descripcionTP) {
                        this.seleccionTP.id = value.id;
                        this.seleccionTP.descripcionTP = value.descripcionTP;
                    }
                });
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD Laboratorio
        TraerTipoCompra() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetTipoCompras", {
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
                                    "No hay datos o no se cargaron los Laboratorios correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarTP() {
            try {
                if (this.nomTipoCompra == "" || this.nomTipoCompra == null) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un Nombre",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        NOMTIPCOM: this.nomTipoCompra.toUpperCase(),
                        CATTIPCOM: this.seleccionTP.descripcionTP.toUpperCase()
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/Mantenedor/PostTipoCompras",
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
                                    text: "Tipo Compra Ingresado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpTP = false;
                                this.TraerTipoCompra();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible registrar el tipo de compra,intentelo nuevamente",
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
        ModificarTP() {
            try {
                let data = {
                    id: this.idMod,
                    NOMTIPCOM: this.nomTipoCompra.toUpperCase(),
                    CATTIPCOM: this.seleccionTP.descripcionTP.toUpperCase()
                };

                const dat = data;

                axios
                    .post(
                        this.localVal + "/api/Mantenedor/PutTipoCompras",
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
                            this.limpiarCampos();
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text: "Tipo Compra Ingresado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.popUpTPMod = false;
                            this.TraerTipoCompra();
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible registrar el tipo de compra,intentelo nuevamente",
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
            this.TraerTipoCompra();
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
