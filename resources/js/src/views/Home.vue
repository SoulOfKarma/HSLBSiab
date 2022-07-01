<template>
    <div>
        <div class="vx-row">
            <div
                class="router-header flex flex-wrap items-center mb-6"
                style="margin-left:10px;"
            ></div>
        </div>
        <div class="vx-row">
            <!-- <div class="vx-col w-full lg:w-1/4 mb-base"></div> -->
            <div class="vx-col w-full mb-base">
                <vx-card
                    slot="no-body"
                    class="text-center bg-primary-gradient greet-user"
                >
                    <feather-icon
                        icon="SunIcon"
                        class="p-6 mb-8 bg-primary inline-flex rounded-full text-white shadow"
                        svgClasses="h-8 w-8"
                    ></feather-icon>
                    <h1 class="mb-6 text-white">Bienvenido!</h1>
                    <p
                        class="xl:w-3/4 lg:w-4/5 md:w-2/3 w-4/5 mx-auto text-white"
                    >
                        SIAB -
                        <strong>Hospital San Luis de Buin(HSLB)</strong>.
                    </p>
                </vx-card>
            </div>
            <!-- <div class="vx-col w-full lg:w-1/4 mb-base"></div> -->
        </div>
        <div class="vx-row">
            <!-- <div class="vx-col w-full lg:w-1/4 mb-base"></div>-->
            <!-- <div class="vx-col w-full lg:w-1/2 mb-base">  -->
            <div class="vx-col w-full lg:w-full mb-base">
                <vx-card title="Informacion del Perfil">
                    <vx-timeline :data="timelineData" />
                </vx-card>
            </div>
            <!-- </div> -->
            <!-- <div class="vx-col w-full lg:w-1/4 mb-base"></div> -->
        </div>
    </div>
</template>
<script>
import axios from "axios";
import VxTimeline from "@/components/timeline/VxTimeline";
import router from "@/router";
export default {
    components: {
        VxTimeline
    },
    data() {
        return {
            externalVal: process.env.MIX_APP_URL_EXTERNA,
            timelineData: [
                {
                    color: "success",
                    icon: "UsersIcon",
                    title: "Inicio",
                    desc:
                        "En esta seccion, aparecera un resumen de las funciones de las secciones que se encuentran en la izquierda"
                },
                {
                    color: "warning",
                    icon: "UsersIcon",
                    title: "Mantenedor",
                    desc:
                        "En esta seccion puede ingresar los datos base que se utilizaran en las otras secciones o datos de usuarios"
                },
                {
                    color: "danger",
                    icon: "UsersIcon",
                    title: "Recepcion",
                    desc:
                        "En esta seccion puede realizar los ingresos de los articulos que son enviados a bodega para que sean registrados y esten a disposicion para el despacho"
                },
                {
                    color: "primary",
                    icon: "UsersIcon",
                    title: "Orden de Compra",
                    desc:
                        "En esta seccion puede validar las recepciones de articulos que estan cerrados para generar su orden de compra"
                },
                {
                    color: "success",
                    icon: "UsersIcon",
                    title: "Despachos",
                    desc:
                        "En esta seccion puede realizar las entregas de los articulos que fueron recepcionados a los usuarios solicitantes"
                },
                {
                    color: "warning",
                    icon: "UsersIcon",
                    title: "Reportes",
                    desc:
                        "En esta seccion puede generar diferentes tipos de reportes segun lo que se requiera"
                }
            ]
        };
    }
};
</script>
<style lang="scss">
@import "@sass/vuexy/components/vxTimeline.scss";
</style>
