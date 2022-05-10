<template>
    <div>
        <vx-card title="Proveedores">
            <div>
                <vs-button color="primary" type="filled" @click="popProveedor"
                    >Agregar Proveedor</vs-button
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
                                    content="Modificar Proveedor"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popModificarProveedor(
                                            props.row.id,
                                            props.row.RUTPROV,
                                            props.row.NOMRAZSOC,
                                            props.row.DIRPROV,
                                            props.row.TELPROV,
                                            props.row.CELPROV,
                                            props.row.EMAILPROV,
                                            props.row.NOMVENPROV
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
                classContent="AgregarProveedor"
                title="Agregar Proveedor"
                :active.sync="popUpProveedor"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row ">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Rut Proveedor</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="rutProveedor"
                                    v-on:blur="formatear_run"
                                />
                                <span
                                    style="font-size: 10px; color: red; margin-left: 10px;"
                                    v-if="val_run"
                                    >Run incorrecto</span
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Razon Social</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="razonSocial"
                                />
                            </div>
                        </div>
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Direccion</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="direccionProveedor"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Telefono</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="telefonoProveedor"
                                />
                            </div>
                        </div>
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Celular</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="celularProveedor"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Email Proveedor</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="emailProveedor"
                                />
                            </div>
                        </div>
                        <div class="vx-row">
                            <div class="vx-col w-full mt-5">
                                <h6>Vendedor</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="vendedorProveedor"
                                />
                            </div>
                        </div>
                        <div class="vx-row w-full md-5">
                            <div class="vx-col w-1/2 md-5">
                                <vs-button
                                    @click="popUpProveedor = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 md-5">
                                <vs-button
                                    @click="AgregarProveedor"
                                    color="success"
                                    type="filled"
                                    class="w-full m-1"
                                    >Agregar Proveedor</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <vs-popup
                classContent="ModificarProveedor"
                title="Modificar Proveedor"
                :active.sync="popUpProveedorMod"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row ">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Rut Proveedor</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="rutProveedor"
                                    v-on:blur="formatear_run"
                                />
                                <span
                                    style="font-size: 10px; color: red; margin-left: 10px;"
                                    v-if="val_run"
                                    >Run incorrecto</span
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Razon Social</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="razonSocial"
                                />
                            </div>
                        </div>
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Direccion</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="direccionProveedor"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Telefono</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="telefonoProveedor"
                                />
                            </div>
                        </div>
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Celular</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="celularProveedor"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Email Proveedor</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="emailProveedor"
                                />
                            </div>
                        </div>
                        <div class="vx-row">
                            <div class="vx-col w-full mt-5">
                                <h6>Vendedor</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="vendedorProveedor"
                                />
                            </div>
                        </div>
                        <div class="vx-row w-full md-5">
                            <div class="vx-col w-1/2 md-5">
                                <vs-button
                                    @click="popUpProveedorMod = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 md-5">
                                <vs-button
                                    @click="ModificarProveedor"
                                    color="warning"
                                    type="filled"
                                    class="w-full m-1"
                                    >Modificar Proveedor</vs-button
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
import vSelect from "vue-select";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import "vue-good-table/dist/vue-good-table.css";
import { VueGoodTable } from "vue-good-table";
import { validate, clean, format } from "rut.js";
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
            popUpProveedor: false,
            popUpProveedorElim: false,
            popUpProveedorMod: false,
            rutProveedor: "",
            razonSocial: "",
            direccionProveedor: "",
            telefonoProveedor: "",
            celularProveedor: "",
            emailProveedor: "",
            vendedorProveedor: "",
            val_run: false,
            idMod: 0,
            //Template Columnas Listado Proveedor
            columns: [
                {
                    label: "Rut Proveedor",
                    field: "RUTPROV",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Razon Social",
                    field: "NOMRAZSOC",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Direccion",
                    field: "DIRPROV",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Telefono",
                    field: "TELPROV",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Celular",
                    field: "CELPROV",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Email Proveedor",
                    field: "EMAILPROV",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Vendedor",
                    field: "NOMVENPROV",
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
            rows: []
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
        formatear_run() {
            if (this.rutProveedor == "" || this.rutProveedor == null) {
                //console.log("Sin Rut");
                this.val_run = false;
            } else {
                this.rutProveedor = format(this.rutProveedor);
                this.val_run = !validate(this.rutProveedor);
            }
        },
        limpiarCampos() {
            try {
                this.rutProveedor = "";
                this.razonSocial = "";
                this.direccionProveedor = "";
                this.telefonoProveedor = "";
                this.celularProveedor = "";
                this.emailProveedor = "";
                this.vendedorProveedor = "";
                this.idModDel = 0;
            } catch (error) {
                console.log("No se pudieron Borrar los Campos");
            }
        },
        //PopUp
        popProveedor() {
            try {
                this.limpiarCampos();
                this.popUpProveedor = true;
            } catch (error) {
                console.log(error);
            }
        },
        popModificarProveedor(
            id,
            runProv,
            RazSocProv,
            DirProv,
            TelProv,
            CelProv,
            EmailProv,
            VenProv
        ) {
            try {
                this.limpiarCampos();
                this.idMod = id;
                this.rutProveedor = runProv;
                this.razonSocial = RazSocProv;
                this.direccionProveedor = DirProv;
                this.telefonoProveedor = TelProv;
                this.celularProveedor = CelProv;
                this.emailProveedor = EmailProv;
                this.vendedorProveedor = VenProv;
                this.popUpProveedorMod = true;
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD Proveedor
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
                        this.rows = res.data;
                        if (this.rows.length < 0) {
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

        AgregarProveedor() {
            try {
                let data = {
                    RUTPROV: this.rutProveedor,
                    NOMRAZSOC: this.razonSocial,
                    DIRPROV: this.direccionProveedor,
                    TELPROV: this.telefonoProveedor,
                    CELPROV: this.celularProveedor,
                    EMAILPROV: this.emailProveedor,
                    NOMVENPROV: this.vendedorProveedor,
                    LLAVEPROVEEDOR: "-",
                    CODFORMAPAGO: "-",
                    CODCOM: "-",
                    CODCIU: "-",
                    CODRUB: "-",
                    CODSIT: "-",
                    CODEST: "-",
                    NUMCRE: "-",
                    NOMFAN: "-",
                    CTACTEPROV: "-",
                    FAXPROV: "-",
                    CODBAN: "-",
                    NOMPERPOD: "-"
                };

                const dat = data;

                axios
                    .post(
                        this.localVal + "/api/Mantenedor/PostProveedor",
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
                                text: "Proveedor Ingresado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.popUpProveedor = false;
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible registrar al proveedor,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        ModificarProveedor() {
            try {
                let data = {
                    id: this.idMod,
                    RUTPROV: this.rutProveedor,
                    NOMRAZSOC: this.razonSocial,
                    DIRPROV: this.direccionProveedor,
                    TELPROV: this.telefonoProveedor,
                    CELPROV: this.celularProveedor,
                    EMAILPROV: this.emailProveedor,
                    NOMVENPROV: this.vendedorProveedor,
                    LLAVEPROVEEDOR: "-",
                    CODFORMAPAGO: "-",
                    CODCOM: "-",
                    CODCIU: "-",
                    CODRUB: "-",
                    CODSIT: "-",
                    CODEST: "-",
                    NUMCRE: "-",
                    NOMFAN: "-",
                    CTACTEPROV: "-",
                    FAXPROV: "-",
                    CODBAN: "-",
                    NOMPERPOD: "-"
                };

                const dat = data;

                axios
                    .post(
                        this.localVal + "/api/Mantenedor/ModificarProveedor",
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
                                text: "Proveedor Modificado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.popUpProveedor = false;
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible Modificar al proveedor,intentelo nuevamente",
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
        this.TraerProveedores();
        this.openLoadingColor();
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1000px;
}
</style>
