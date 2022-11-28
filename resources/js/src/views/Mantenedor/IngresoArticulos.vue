<template>
    <div>
        <vx-card title="Gestionador de Articulos">
            <div class="vx-row">
                <div class="vx-col w-1/2 mt-2">
                    <h6>Bodega</h6>
                    <v-select
                        v-model="seleccionBodegaL"
                        placeholder="Activo"
                        class="w-full select-large"
                        label="descripcionBodega"
                        :options="listaBodegaL"
                    ></v-select>
                </div>
                <div class="vx-col w-1/2 mt-2">
                    <h6>Ingrese Codigo o Descripcion a Buscar</h6>
                    <vs-input
                        class="inputx w-full  "
                        v-model="codbusqueda"
                        v-on:keydown.enter="cargaItemBodega"
                    />
                </div>
            </div>
            <br />
            <div v-if="articulosgen">
                <div>
                    <vs-button
                        class="inputx w-full  "
                        color="primary"
                        type="filled"
                        @click="popArticuloGeneral"
                        >Agregar Articulo</vs-button
                    >
                </div>
                <br />
                <div>
                    <vx-card>
                        <vs-table max-items="10" search :data="rows">
                            <template slot="header"> </template>
                            <template slot="thead">
                                <vs-th>
                                    Codigo Barra
                                </vs-th>
                                <vs-th>
                                    Codigo Onu
                                </vs-th>
                                <vs-th>
                                    Codigo Interno
                                </vs-th>
                                <vs-th>
                                    Nombre Articulo
                                </vs-th>
                                <vs-th>
                                    Bodega
                                </vs-th>
                                <vs-th>
                                    Unidad Medida
                                </vs-th>
                                <vs-th>
                                    Opciones
                                </vs-th>
                            </template>

                            <template slot-scope="{ data }">
                                <vs-tr
                                    :key="indextr"
                                    v-for="(tr, indextr) in data"
                                >
                                    <vs-td :data="data[indextr].CODART_BARR">
                                        {{ data[indextr].CODART_BARR }}
                                    </vs-td>
                                    <vs-td :data="data[indextr].CODART_ONU">
                                        {{ data[indextr].CODART_ONU }}
                                    </vs-td>
                                    <vs-td :data="data[indextr].CODART">
                                        {{ data[indextr].CODART }}
                                    </vs-td>

                                    <vs-td :data="data[indextr].NOMBRE">
                                        {{ data[indextr].NOMBRE }}
                                    </vs-td>

                                    <vs-td
                                        :data="data[indextr].descripcionBodega"
                                    >
                                        {{ data[indextr].descripcionBodega }}
                                    </vs-td>

                                    <vs-td :data="data[indextr].UNIMEDBASE">
                                        {{ data[indextr].UNIMEDBASE }}
                                    </vs-td>
                                    <vs-td :data="data[indextr].id">
                                        <edit-icon
                                            v-if="ModificaArt == 3"
                                            content="Modificar Articulo General"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                popArticuloGeneralMod(
                                                    data[indextr].id,
                                                    data[indextr].NOMBRE,
                                                    data[indextr].UNIMEDBASE,
                                                    data[indextr].CODART_ONU,
                                                    data[indextr].CODART,
                                                    data[indextr].CODART_BARR,
                                                    data[indextr].idEstado,
                                                    data[indextr].UBICACION,
                                                    data[indextr].SECTOR,
                                                    data[indextr].idBodega,
                                                    data[indextr].idZona,
                                                    data[indextr].CANTXENB,
                                                    data[indextr].NOMFAM1,
                                                    data[indextr].NOMFAM2,
                                                    data[indextr].NOMFAM3,
                                                    data[indextr].NOMFAM4,
                                                    data[indextr].NOMFAM5,
                                                    data[indextr].idACT_FECVEN,
                                                    data[indextr].idACTLOTE,
                                                    data[indextr].NOMARCH,
                                                    data[indextr].PRECIO_BASE
                                                )
                                            "
                                        ></edit-icon>
                                        <file-plus-icon
                                            content="Agregar Codigo Articulo"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                popCodArticuloGeneral(
                                                    data[indextr].NOMBRE,
                                                    data[indextr].UNIMEDBASE,
                                                    data[indextr].CODART_ONU,
                                                    data[indextr].CODART,
                                                    data[indextr].CODART_BARR,
                                                    data[indextr].idEstado,
                                                    data[indextr].UBICACION,
                                                    data[indextr].SECTOR,
                                                    data[indextr].idBodega,
                                                    data[indextr].idZona,
                                                    data[indextr].CANTXENB,
                                                    data[indextr].NOMFAM1,
                                                    data[indextr].NOMFAM2,
                                                    data[indextr].NOMFAM3,
                                                    data[indextr].NOMFAM4,
                                                    data[indextr].NOMFAM5,
                                                    data[indextr].idACT_FECVEN,
                                                    data[indextr].idACTLOTE,
                                                    data[indextr].PRECIO_BASE
                                                )
                                            "
                                        ></file-plus-icon>
                                    </vs-td>
                                </vs-tr>
                            </template>
                        </vs-table>
                    </vx-card>
                </div>
            </div>
            <div v-if="medicamento">
                <div>
                    <vs-button
                        class="inputx w-full  "
                        color="primary"
                        type="filled"
                        @click="popMedicamento"
                        >Agregar Medicamento</vs-button
                    >
                </div>
                <br />
                <div>
                    <vx-card>
                        <vs-table max-items="10" search :data="rows">
                            <template slot="header"> </template>
                            <template slot="thead">
                                <vs-th>
                                    Codigo Barra
                                </vs-th>
                                <vs-th>
                                    Codigo Interno
                                </vs-th>
                                <vs-th>
                                    Nombre Articulo
                                </vs-th>
                                <vs-th>
                                    Bodega
                                </vs-th>
                                <vs-th>
                                    Unidad Medida
                                </vs-th>
                                <vs-th>
                                    Laboratorio
                                </vs-th>
                                <vs-th>
                                    Concentracion
                                </vs-th>
                                <vs-th>
                                    Opciones
                                </vs-th>
                            </template>

                            <template slot-scope="{ data }">
                                <vs-tr
                                    :key="indextr"
                                    v-for="(tr, indextr) in data"
                                >
                                    <vs-td :data="data[indextr].CODART_BARR">
                                        {{ data[indextr].CODART_BARR }}
                                    </vs-td>
                                    <vs-td :data="data[indextr].CODART">
                                        {{ data[indextr].CODART }}
                                    </vs-td>

                                    <vs-td :data="data[indextr].NOMBRE">
                                        {{ data[indextr].NOMBRE }}
                                    </vs-td>

                                    <vs-td
                                        :data="data[indextr].descripcionBodega"
                                    >
                                        {{ data[indextr].descripcionBodega }}
                                    </vs-td>

                                    <vs-td :data="data[indextr].UNIMEDBASE">
                                        {{ data[indextr].UNIMEDBASE }}
                                    </vs-td>
                                    <vs-td :data="data[indextr].LABORATORIO">
                                        {{ data[indextr].LABORATORIO }}
                                    </vs-td>
                                    <vs-td :data="data[indextr].CONCENTRACION">
                                        {{ data[indextr].CONCENTRACION }}
                                    </vs-td>
                                    <vs-td>
                                        <plus-circle-icon
                                            v-if="ModificaArt == 3"
                                            content="Modificar Medicamento"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                popModificarMedicamento(
                                                    data[indextr].id,
                                                    data[indextr].CODART_TRACK,
                                                    data[indextr].NOMBRE,
                                                    data[indextr].GENERICO,
                                                    data[indextr].CAT_FARMACIA,
                                                    data[indextr].UNIMEDBASE,
                                                    data[indextr].CONCENTRACION,
                                                    data[indextr].CODART_ONU,
                                                    data[indextr].CODART,
                                                    data[indextr].CODART_BARR,
                                                    data[indextr].UBICACION,
                                                    data[indextr].SECTOR,
                                                    data[indextr].ZGEN,
                                                    data[indextr].idBodega,
                                                    data[indextr].idZona,
                                                    data[indextr].idEstado,
                                                    data[indextr].LABORATORIO,
                                                    data[indextr].CANTXENB,
                                                    data[indextr].idACT_FECVEN,
                                                    data[indextr].idACTLOTE,
                                                    data[indextr].NOMARCH,
                                                    data[indextr].PRECIO_BASE
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
                                                    data[indextr].CODART_TRACK,
                                                    data[indextr].NOMBRE,
                                                    data[indextr].GENERICO,
                                                    data[indextr].CAT_FARMACIA,
                                                    data[indextr].UNIMEDBASE,
                                                    data[indextr].CONCENTRACION,
                                                    data[indextr].CODART_ONU,
                                                    data[indextr].CODART,
                                                    data[indextr].CODART_BARR,
                                                    data[indextr].UBICACION,
                                                    data[indextr].SECTOR,
                                                    data[indextr].ZGEN,
                                                    data[indextr].idBodega,
                                                    data[indextr].idZona,
                                                    data[indextr].idEstado,
                                                    data[indextr].LABORATORIO,
                                                    data[indextr].CANTXENB,
                                                    data[indextr].idACT_FECVEN,
                                                    data[indextr].idACTLOTE,
                                                    data[indextr].PRECIO_BASE
                                                )
                                            "
                                        ></plus-circle-icon>
                                    </vs-td>
                                </vs-tr>
                            </template>
                        </vs-table>
                    </vx-card>
                </div>
            </div>
            <!-- Agregar Articulos Generales-->
            <vs-popup
                classContent="AgregarArticulosGenerales"
                title="Agregar Articulo"
                :active.sync="popUpArticuloGeneral"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Bodega</h6>

                                <v-select
                                    v-model="seleccionBodega"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionBodega"
                                    :options="listaBodega"
                                    @input="cargaItemBodegaFamilia"
                                    disabled
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Codigo de Barra
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codigoBarra"
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
                                <h6>Descripcion Familia 1</h6>

                                <v-select
                                    v-model="seleccionFamilia1"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia1"
                                    @input="cargaItemFamilia1"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Descripcion Familia 2</h6>

                                <v-select
                                    v-model="seleccionFamilia2"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia2"
                                    @input="cargaItemFamilia2"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Descripcion Familia 3</h6>

                                <v-select
                                    v-model="seleccionFamilia3"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia3"
                                    @input="cargaItemFamilia3"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Descripcion Familia 4</h6>

                                <v-select
                                    v-model="seleccionFamilia4"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia4"
                                    @input="cargaItemFamilia4"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Descripcion Familia 5</h6>

                                <v-select
                                    v-model="seleccionFamilia5"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia5"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Unidad Medida Base</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="unidadMedidaBase"
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
                                <h6>Cantidad Embalaje</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="cantidadEmbalaje"
                                />
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
                                <h6>Activacion Covid 19</h6>

                                <v-select
                                    v-model="seleccionCovid"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionCovid"
                                    :options="listaCovid"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Precio Base</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="precio_base"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                        </div>
                        <br />

                        <div class="vx-row w-full">
                            <vx-card title="Adjuntar Imagen">
                                <div class="vx-row mb-12">
                                    <div class="vx-col w-1/8 mt-5">
                                        <vs-input
                                            type="file"
                                            id="archivo"
                                            @change="handleImage"
                                            class="form-control w-full"
                                        />
                                    </div>
                                    <div class="vx-col w-1/2 mt-5">
                                        <h5 class="w-full ">
                                            <p class="pt-4 text-justify">
                                                {{ nombrearchivo }}
                                            </p>
                                        </h5>
                                    </div>
                                </div>
                            </vx-card>
                        </div>
                        <br />
                        <div class="vx-row w-full">
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="popUpArticuloGeneral = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="AgregarArticulosGenerales"
                                    color="success"
                                    type="filled"
                                    class="w-full"
                                    >Agregar Articulo</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <!-- Modificar Articulos Generales-->
            <vs-popup
                classContent="ModificarArticulosGenerales"
                title="Modificar Articulo"
                :active.sync="popUpArticuloGeneralMod"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Bodega</h6>
                                <v-select
                                    v-model="seleccionBodega"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionBodega"
                                    :options="listaBodega"
                                    @input="cargaItemBodegaFamilia"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>
                                    Codigo de Barra
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codigoBarra"
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
                                <h6>Descripcion Familia 1</h6>

                                <v-select
                                    v-model="seleccionFamilia1"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia1"
                                    @input="cargaItemFamilia1"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Descripcion Familia 2</h6>

                                <v-select
                                    v-model="seleccionFamilia2"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia2"
                                    @input="cargaItemFamilia2"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Descripcion Familia 3</h6>

                                <v-select
                                    v-model="seleccionFamilia3"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia3"
                                    @input="cargaItemFamilia3"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Descripcion Familia 4</h6>

                                <v-select
                                    v-model="seleccionFamilia4"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia4"
                                    @input="cargaItemFamilia4"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Descripcion Familia 5</h6>

                                <v-select
                                    v-model="seleccionFamilia5"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionFamilia"
                                    :options="listaFamilia5"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Unidad Medida Base</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="unidadMedidaBase"
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
                                <h6>Cantidad Embalaje</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="cantidadEmbalaje"
                                />
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
                                <h6>Activacion Covid 19</h6>

                                <v-select
                                    v-model="seleccionCovid"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionCovid"
                                    :options="listaCovid"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Precio Base</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="precio_base"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                        </div>
                        <br />
                        <div class="vx-row w-full">
                            <vx-card title="Adjuntar Imagen">
                                <div class="vx-row mb-12">
                                    <div class="vx-col w-1/8 mt-5">
                                        <vs-input
                                            type="file"
                                            id="archivo"
                                            @change="handleImage"
                                            class="form-control w-full"
                                        />
                                        <h5 class="w-full ">
                                            <p class="pt-4 text-justify">
                                                {{ nombrearchivo }}
                                            </p>
                                        </h5>
                                    </div>
                                    <div
                                        class="vx-col w-1/2 mt-5 con-example-images"
                                        slot="media"
                                        type="flex"
                                        vs-justify="center"
                                        vs-align="center"
                                    >
                                        <div>
                                            <img :src="localDoc + nomarchivo" />
                                        </div>
                                    </div>
                                </div>
                            </vx-card>
                        </div>
                        <br />
                        <div class="vx-row w-full">
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="popUpArticuloGeneralMod = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="ModificarArticulosGenerales"
                                    color="success"
                                    type="filled"
                                    class="w-full"
                                    >Modificar Articulo</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <!-- Codigo Articulos Generales-->
            <vs-popup
                classContent="CEcoMod"
                title="Agregar Codigo Articulo"
                :active.sync="popUpCodArticuloGeneral"
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
                                    @input="cargaItemBodegaFamilia"
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
                                    @click="AgregarCodArticulosGenerales"
                                    color="success"
                                    type="filled"
                                    class="w-full"
                                    >Agregar Codigo Articulo</vs-button
                                >
                            </div>
                        </div>
                        <div class="vx-row">
                            <vx-card>
                                <vue-good-table
                                    :columns="col"
                                    :rows="listaCodNuevo"
                                    :pagination-options="PageOptions"
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
                                        <span
                                            v-else-if="
                                                props.column.field === 'action'
                                            "
                                        >
                                            <plus-circle-icon
                                                content="Modificar Codigo"
                                                v-tippy
                                                size="1.5x"
                                                class="custom-class"
                                                @click="
                                                    popModificarCodigo(
                                                        props.row.id,
                                                        props.row.CODART_BARR
                                                    )
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
                            </vx-card>
                        </div>
                        <br />
                        <div class="vx-row w-full">
                            <div class="vx-col w-full mt-5">
                                <vs-button
                                    @click="popUpCodArticuloGeneral = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>

            <!-- Seccion Pop Medicamentos -->
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
                                <v-select
                                    v-model="seleccionLaboratorio"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="LABORATORIO"
                                    :options="listaLaboratorio"
                                ></v-select>
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
                                    disabled
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
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Activacion Covid 19</h6>

                                <v-select
                                    v-model="seleccionCovid"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionCovid"
                                    :options="listaCovid"
                                ></v-select>
                            </div>
                            <div class="vx-col w-full mt-5">
                                <h6>Precio Base</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="precio_base"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                        </div>
                        <br />
                        <div class="vx-row w-full">
                            <vx-card title="Adjuntar Imagen">
                                <div class="vx-row mb-12">
                                    <div class="vx-col w-1/8 mt-5">
                                        <vs-input
                                            type="file"
                                            id="archivo"
                                            @change="handleImage"
                                            class="form-control w-full"
                                        />
                                    </div>
                                    <div class="vx-col w-1/2 mt-5">
                                        <h5 class="w-full ">
                                            <p class="pt-4 text-justify">
                                                {{ nombrearchivo }}
                                            </p>
                                        </h5>
                                    </div>
                                </div>
                            </vx-card>
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
                                <v-select
                                    v-model="seleccionLaboratorio"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="LABORATORIO"
                                    :options="listaLaboratorio"
                                ></v-select>
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
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Activacion Covid 19</h6>

                                <v-select
                                    v-model="seleccionCovid"
                                    placeholder="Activo"
                                    class="w-full select-large"
                                    label="descripcionCovid"
                                    :options="listaCovid"
                                ></v-select>
                            </div>
                            <div class="vx-col w-full mt-5">
                                <h6>Precio Base</h6>

                                <vs-input
                                    class="inputx w-full  "
                                    v-model="precio_base"
                                    @keypress="isNumber($event)"
                                />
                            </div>
                        </div>
                        <br />
                        <div class="vx-row w-full">
                            <vx-card title="Adjuntar Imagen">
                                <div class="vx-row mb-12">
                                    <div class="vx-col w-1/8 mt-5">
                                        <vs-input
                                            type="file"
                                            id="archivo"
                                            @change="handleImage"
                                            class="form-control w-full"
                                        />
                                        <h5 class="w-full ">
                                            <p class="pt-4 text-justify">
                                                {{ nombrearchivo }}
                                            </p>
                                        </h5>
                                    </div>
                                    <div
                                        class="vx-col w-1/2 mt-5 con-example-images"
                                        slot="media"
                                        type="flex"
                                        vs-justify="center"
                                        vs-align="center"
                                    >
                                        <div>
                                            <img :src="localDoc + nomarchivo" />
                                        </div>
                                    </div>
                                </div>
                            </vx-card>
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
                                    :columns="colMed"
                                    :rows="listaCodNuevo"
                                    :pagination-options="PageOptions"
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
                                        <span
                                            v-else-if="
                                                props.column.field === 'action'
                                            "
                                        >
                                            <plus-circle-icon
                                                content="Modificar Codigo"
                                                v-tippy
                                                size="1.5x"
                                                class="custom-class"
                                                @click="
                                                    popModificarCodigo(
                                                        props.row.id,
                                                        props.row.CODART_BARR,
                                                        props.row.CODART
                                                    )
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
            <!-- Seccion Pop Modificar Codigo Barra -->
            <vs-popup
                classContent="ModificarCodigoBarra"
                title="Modificar Codigo de barra"
                :active.sync="popUpModificarCodigo"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-full mt-5">
                                <h6>
                                    Codigo de Barra
                                </h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codigoBarra"
                                />
                            </div>
                        </div>
                        <br />
                        <div class="vx-row w-full">
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="popUpModificarCodigo = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="ModificarCodigoBarra"
                                    color="success"
                                    type="filled"
                                    class="w-full"
                                    >Modificar Codigo de Barra</vs-button
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
import store from "./storeArticulos.js";
import vSelect from "vue-select";
import "vue-good-table/dist/vue-good-table.css";
import { VueGoodTable } from "vue-good-table";
import { PlusCircleIcon } from "vue-feather-icons";
import Vue from "vue";
import Vuex from "vuex";
import VueTippy, { TippyComponent } from "vue-tippy";
import storePage from "../ScriptMenus/store.js";
import { FilePlusIcon } from "vue-feather-icons";
import { EditIcon } from "vue-feather-icons";
Vue.use(VueTippy);
Vue.component("tippy", TippyComponent);

export default {
    components: {
        VueGoodTable,
        "v-select": vSelect,
        PlusCircleIcon,
        FilePlusIcon,
        EditIcon
    },
    data() {
        return {
            //Datos Locales - Variables de Entorno
            localVal: process.env.MIX_APP_URL,
            localDoc: process.env.MIX_APP_URL_DOCUMENTOS,
            externalVal: process.env.MIX_APP_URL_PA,
            //Datos Campos
            PageOptions: storePage.state.PageOptions,
            ModificaArt: localStorage.getItem("permiso_usuario"),
            popUpMedicamento: false,
            popUpMedicamentoMod: false,
            popUpNCMedicamento: false,
            descripcionServicio: "",
            popUpArticuloGeneral: false,
            popUpArticuloGeneralMod: false,
            popUpCodArticuloGeneral: false,
            popUpModificarCodigo: false,
            codigoBarra: "-",
            codigoBarraOriginal: "-",
            codigoOnu: "-",
            codigoTrack: "-",
            codigoArticulo: "-",
            nombre: "-",
            generico: "-",
            categoriaFarmacia: "-",
            laboratorio: "-",
            idEstado: "-",
            concentracion: "-",
            actFechaVencimiento: false,
            actLoteSerie: false,
            medicamento: false,
            articulosgen: false,
            cantidadEmbalaje: 1,
            codbusqueda: "",
            idBodega: "-",
            idZona: "-",
            sector: "-",
            ubicacion: "-",
            hover: "blur",
            zgen: "-",
            precio_base: 0,
            unidadMedidaBase: "",
            image: null,
            nombrearchivo: "",
            codMedEcoIns: 0,
            nomarchivo: "",
            seleccionEstado: {
                id: 0,
                descripcionEstado: ""
            },
            seleccionBodega: {
                id: 0,
                descripcionBodega: "Seleccione Bodega"
            },
            seleccionBodegaL: {
                id: 0,
                descripcionBodega: "Seleccione Bodega"
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
            seleccionLaboratorio: {
                id: 0,
                LABORATORIO: "Seleccion Laboratorio"
            },
            seleccionCovid: {
                id: 2,
                descripcionCovid: "No"
            },
            seleccionFamilia1: {
                id: 0,
                descripcionFamilia: "",
                idBodega: 0,
                CODFAM1: ""
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
            idMod: 0,
            //Columnas Generales
            columns: store.state.columns,
            col: store.state.col,
            //Columnas Medicamentos
            columnsMed: store.state.columnsMed,
            colMed: store.state.colMed,
            //Datos Listado Proveedor
            rows: [],
            rowsMed: [],
            listaLaboratorio: [],
            listaCodNuevo: [],
            listaEstado: [],
            listaBodega: [],
            listaBodegaL: [],
            listaZona: [],
            listaFamilia1: [],
            listaFamilia2: [],
            listaFamilia3: [],
            listaFamilia4: [],
            listaFamilia5: [],
            listaTempFamilia1: [],
            listaTempFamilia2: [],
            listaTempFamilia3: [],
            listaTempFamilia4: [],
            listaTempFamilia5: [],
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
            ],
            listaCovid: [
                {
                    id: 1,
                    descripcionCovid: "Si"
                },
                {
                    id: 2,
                    descripcionCovid: "No"
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
        handleImage(e) {
            try {
                this.image = e.target.files[0];
                this.nombrearchivo = this.image.name;
            } catch (error) {
                console.log(error);
            }
        },
        limpiarCampos() {
            try {
                this.codigoBarra = "-";
                this.codigoTrack = "-";
                this.codigoOnu = "-";
                this.codigoArticulo = "-";
                this.generico = "-";
                this.categoriaFarmacia = "-";
                this.nombre = "-";
                this.concentracion = "-";
                this.laboratorio = "-";
                this.seleccionEstado = {
                    id: 1,
                    descripcionEstado: "Activo"
                };
                this.seleccionFechaVenciminento = {
                    id: 1,
                    descripcionFVen: "Si"
                };
                this.seleccionLoteSerie = {
                    id: 1,
                    descripcionLoteSerie: "Si"
                };
                this.cantidadEmbalaje = 1;
                this.idZona = 0;
                this.seleccionZona = {
                    id: 1,
                    descripcionZonas: "A"
                };
                this.sector = "-";
                this.ubicacion = "-";
                this.zgen = "-";
                this.seleccionFamilia1 = {
                    id: 0,
                    descripcionFamilia: "",
                    idBodega: 0
                };
                this.seleccionFamilia2 = {
                    id: 0,
                    descripcionFamilia: "",
                    idDesFam: 0
                };
                this.seleccionFamilia3 = {
                    id: 0,
                    descripcionFamilia: "",
                    idDesFam01: 0
                };
                this.seleccionFamilia4 = {
                    id: 0,
                    descripcionFamilia: "",
                    idDesFam02: 0
                };
                this.seleccionFamilia5 = {
                    id: 0,
                    descripcionFamilia: "",
                    idDesFam03: 0
                };
                this.unidadMedidaBase = "-";
                this.idMod = 0;
                this.precio_base = 0;
            } catch (error) {
                console.log(error);
            }
        },
        popModificarCodigo(id, codbar, codart) {
            try {
                this.idMod = id;
                this.codigoBarra = codbar;
                this.codigoBarraOriginal = codbar;
                this.popUpModificarCodigo = true;
                if (this.popUpNCMedicamento == true) {
                    this.codMedEcoIns = 1;
                } else {
                    this.codMedEcoIns = 2;
                }
                this.popUpCodArticuloGeneral = false;
                this.popUpNCMedicamento = false;
                this.codigoArticulo = codart;
            } catch (error) {
                console.log(error);
            }
        },
        cargaItemBodega() {
            try {
                this.TraerProductos();
                if (this.seleccionBodegaL.id == 1) {
                    this.medicamento = true;
                    this.articulosgen = false;
                } else if (this.seleccionBodegaL.id > 1) {
                    this.medicamento = false;
                    this.articulosgen = true;
                }

                this.seleccionBodega = {
                    id: 0,
                    descripcionBodega: ""
                };

                this.seleccionBodega = {
                    id: this.seleccionBodegaL.id,
                    descripcionBodega: this.seleccionBodegaL.descripcionBodega
                };

                let f = this.rowsMed;
                let g = [];

                f.forEach((value, index) => {
                    if (this.seleccionBodegaL.id == value.idBodega) {
                        g.push(value);
                    }
                });

                this.rows = g;
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
                    if (b == value.idBodega) {
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
                let b = this.seleccionFamilia1.CODFAM1;
                let a = [];
                c.forEach((value, index) => {
                    if (b == value.idDesFam) {
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
                let b = this.seleccionFamilia2.CODFAM2;
                let a = [];
                c.forEach((value, index) => {
                    if (b == value.idDesFam01) {
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
                let b = this.seleccionFamilia3.CODFAM3;
                let a = [];
                c.forEach((value, index) => {
                    if (b == value.idDesFam02) {
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
                let b = this.seleccionFamilia4.CODFAM4;
                let a = [];
                c.forEach((value, index) => {
                    if (b == value.idDesFam03) {
                        a.push(value);
                    }
                });

                this.listaFamilia5 = a;
            } catch (error) {
                console.log(error);
            }
        },
        cargaBodegaMod(idBodega) {
            try {
                this.seleccionBodega = {
                    id: 0,
                    descripcionBodega: ""
                };
                let c = this.listaBodega;
                let a = [];
                c.forEach((value, index) => {
                    if (idBodega == value.id) {
                        let dato = {
                            id: value.id,
                            descripcionBodega: value.descripcionBodega
                        };
                        a = dato;
                    }
                });

                this.seleccionBodega.id = a.id;
                this.seleccionBodega.descripcionBodega = a.descripcionBodega;
            } catch (error) {
                console.log(error);
            }
        },
        //PopUp General
        popArticuloGeneral() {
            try {
                this.popUpArticuloGeneral = true;
                this.limpiarCampos();
                this.cargaItemBodegaFamilia();
            } catch (error) {
                console.log(error);
            }
        },
        popArticuloGeneralMod(
            id,
            NOMBRE,
            UNIMEDBASE,
            CODART_ONU,
            CODART,
            CODART_BARR,
            idEstado,
            UBICACION,
            SECTOR,
            idBodega,
            idZona,
            CANTXENB,
            NOMFAM1,
            NOMFAM2,
            NOMFAM3,
            NOMFAM4,
            NOMFAM5,
            idACT_FECVEN,
            idACTLOTE,
            NOMARCH,
            PRECIO_BASE
        ) {
            try {
                this.limpiarCampos();
                this.popUpArticuloGeneralMod = true;
                this.idMod = id;
                this.codigoBarra = CODART_BARR;
                this.codigoOnu = CODART_ONU;
                this.codigoArticulo = CODART;
                this.nombre = NOMBRE;
                this.nomarchivo = NOMARCH;
                let c = this.listaEstado;
                this.precio_base = PRECIO_BASE;

                c.forEach((value, index) => {
                    if (idEstado == value.id) {
                        this.seleccionEstado.id = value.id;
                        this.seleccionEstado.descripcionEstado =
                            value.descripcionEstado;
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

                this.cantidadEmbalaje = CANTXENB;
                this.cargaBodegaMod(idBodega);

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
                this.sector = SECTOR;
                this.ubicacion = UBICACION;

                c = this.listaTempFamilia1;

                c.forEach((value, index) => {
                    if (NOMFAM1 == value.descripcionFamilia) {
                        this.seleccionFamilia1.id = value.id;
                        this.seleccionFamilia1.idBodega = value.idBodega;
                        this.seleccionFamilia1.CODFAM1 = value.CODFAM1;
                        this.seleccionFamilia1.descripcionFamilia =
                            value.descripcionFamilia;
                    }
                });

                c = [];

                c = this.listaTempFamilia2;

                c.forEach((value, index) => {
                    if (NOMFAM2 == value.descripcionFamilia) {
                        this.seleccionFamilia2.id = value.id;
                        this.seleccionFamilia2.idDesFam = value.idDesFam;
                        this.seleccionFamilia2.descripcionFamilia =
                            value.descripcionFamilia;
                        this.seleccionFamilia2.CODFAM2 = value.CODFAM2;
                    }
                });

                c = [];

                c = this.listaTempFamilia3;

                c.forEach((value, index) => {
                    if (NOMFAM3 == value.descripcionFamilia) {
                        this.seleccionFamilia3.id = value.id;
                        this.seleccionFamilia3.idDesFam01 = value.idDesFam01;
                        this.seleccionFamilia3.descripcionFamilia =
                            value.descripcionFamilia;
                        this.seleccionFamilia3.CODFAM3 = value.CODFAM3;
                    }
                });

                c = [];

                c = this.listaTempFamilia4;

                c.forEach((value, index) => {
                    if (NOMFAM4 == value.descripcionFamilia) {
                        this.seleccionFamilia4.id = value.id;
                        this.seleccionFamilia4.idDesFam02 = value.idDesFam02;
                        this.seleccionFamilia4.descripcionFamilia =
                            value.descripcionFamilia;
                        this.seleccionFamilia4.CODFAM4 = value.CODFAM4;
                    }
                });

                c = [];

                c = this.listaTempFamilia5;

                c.forEach((value, index) => {
                    if (NOMFAM5 == value.descripcionFamilia) {
                        this.seleccionFamilia5.id = value.id;
                        this.seleccionFamilia5.idDesFam03 = value.idDesFam03;
                        this.seleccionFamilia5.descripcionFamilia =
                            value.descripcionFamilia;
                        this.seleccionFamilia5.CODFAM5 = value.CODFAM5;
                    }
                });
                this.cargaItemBodegaFamilia();
                this.cargaItemFamilia1();
                this.cargaItemFamilia2();
                this.cargaItemFamilia3();
                this.cargaItemFamilia4();
                this.unidadMedidaBase = UNIMEDBASE;
            } catch (error) {
                console.log(error);
            }
        },
        popCodArticuloGeneral(
            NOMBRE,
            UNIMEDBASE,
            CODART_ONU,
            CODART,
            CODART_BARR,
            idEstado,
            UBICACION,
            SECTOR,
            idBodega,
            idZona,
            CANTXENB,
            NOMFAM1,
            NOMFAM2,
            NOMFAM3,
            NOMFAM4,
            NOMFAM5,
            idACT_FECVEN,
            idACTLOTE,
            PRECIO_BASE
        ) {
            try {
                this.limpiarCampos();
                this.popUpCodArticuloGeneral = true;
                this.codigoBarra = CODART_BARR;
                this.codigoOnu = CODART_ONU;
                this.codigoArticulo = CODART;
                this.nombre = NOMBRE;
                let c = this.listaEstado;
                this.precio_base = PRECIO_BASE;
                c.forEach((value, index) => {
                    if (idEstado == value.id) {
                        this.seleccionEstado.id = value.id;
                        this.seleccionEstado.descripcionEstado =
                            value.descripcionEstado;
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
                this.cantidadEmbalaje = CANTXENB;
                this.cargaBodegaMod(idBodega);
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
                this.sector = SECTOR;
                this.ubicacion = UBICACION;
                c = this.listaTempFamilia1;
                c.forEach((value, index) => {
                    if (NOMFAM1 == value.descripcionFamilia) {
                        this.seleccionFamilia1.id = value.id;
                        this.seleccionFamilia1.idBodega = value.idBodega;
                        this.seleccionFamilia1.descripcionFamilia =
                            value.descripcionFamilia;
                    }
                });
                c = [];
                c = this.listaTempFamilia2;
                c.forEach((value, index) => {
                    if (NOMFAM2 == value.descripcionFamilia) {
                        this.seleccionFamilia2.id = value.id;
                        this.seleccionFamilia2.idDesFam = value.idDesFam;
                        this.seleccionFamilia2.descripcionFamilia =
                            value.descripcionFamilia;
                    }
                });
                c = [];
                c = this.listaTempFamilia3;
                c.forEach((value, index) => {
                    if (NOMFAM3 == value.descripcionFamilia) {
                        this.seleccionFamilia3.id = value.id;
                        this.seleccionFamilia3.idDesFam01 = value.idDesFam01;
                        this.seleccionFamilia3.descripcionFamilia =
                            value.descripcionFamilia;
                    }
                });
                c = [];
                c = this.listaTempFamilia4;
                c.forEach((value, index) => {
                    if (NOMFAM4 == value.descripcionFamilia) {
                        this.seleccionFamilia4.id = value.id;
                        this.seleccionFamilia4.idDesFam02 = value.idDesFam02;
                        this.seleccionFamilia4.descripcionFamilia =
                            value.descripcionFamilia;
                    }
                });
                c = [];
                c = this.listaTempFamilia5;
                c.forEach((value, index) => {
                    if (NOMFAM5 == value.descripcionFamilia) {
                        this.seleccionFamilia5.id = value.id;
                        this.seleccionFamilia5.idDesFam03 = value.idDesFam03;
                        this.seleccionFamilia5.descripcionFamilia =
                            value.descripcionFamilia;
                    }
                });
                this.unidadMedidaBase = UNIMEDBASE;
                this.TraerDetalleByCodInterno(CODART);
            } catch (error) {
                console.log(error);
            }
        },
        //Pop Medicamentos
        popMedicamento() {
            try {
                this.popUpMedicamento = true;
                this.limpiarCampos();
                this.cargaItemBodegaFamilia();
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
            idACTLOTE,
            NOMARCH,
            PRECIO_BASE
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
                this.nomarchivo = NOMARCH;
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
                c = this.listaLaboratorio;
                c.forEach((value, index) => {
                    if (LABORATORIO == value.LABORATORIO) {
                        this.seleccionLaboratorio.id = value.id;
                        this.seleccionLaboratorio.LABORATORIO =
                            value.LABORATORIO;
                    }
                });
                this.cantidadEmbalaje = CANTXENB;
                this.cargaBodegaMod(idBodega);

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
                this.precio_base = PRECIO_BASE;
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
            idACTLOTE,
            PRECIO_BASE
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
                this.precio_base = PRECIO_BASE;

                this.TraerDetalleByCodInterno(CODART);
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD Articulos Generales
        TraerDetalleByCodInterno(codigoInterno) {
            try {
                if (this.seleccionBodega == 1) {
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
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            this.listaCodNuevo = res.data;
                        });
                } else {
                    let data = { CODART: codigoInterno };

                    const dat = data;

                    axios
                        .post(
                            this.localVal +
                                "/api/Mantenedor/GetListadoArticulosByCodInterno",
                            dat,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            this.listaCodNuevo = res.data;
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        TraerLaboratorios() {
            store.dispatch("TraerLaboratorios").then(() => {
                let laboratorios = store.getters.getLaboratorios;
                this.listaLaboratorio = laboratorios;
            });
        },
        TraerProductos() {
            try {
                this.rows = [];
                if (this.seleccionBodegaL.id > 0) {
                    if (this.codbusqueda.length > 0) {
                        let data = {
                            idBodega: this.seleccionBodegaL.id,
                            DATA: this.codbusqueda
                        };

                        const dat = data;

                        axios
                            .post(
                                this.localVal +
                                    "/api/Mantenedor/GetProductosByBodDes",
                                dat,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            localStorage.getItem("token")
                                    }
                                }
                            )
                            .then(res => {
                                this.rows = res.data;
                            });
                    }
                } else {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "Debe seleccionar Bodega o Ingresar alguna referencia para buscar articulos",
                        color: "danger",
                        position: "top-right"
                    });
                }
            } catch (error) {
                console.log(error);
            }
        },
        TraerEstado() {
            store.dispatch("TraerEstado").then(() => {
                let estado = store.getters.getEstados;
                this.listaEstado = estado;
            });
        },
        TraerBodega() {
            store.dispatch("TraerBodega").then(() => {
                let bodega = store.getters.getBodegas;
                this.listaBodega = bodega;
                this.listaBodegaL = bodega;
            });
        },
        TraerZona() {
            store.dispatch("TraerZona").then(() => {
                let zonas = store.getters.getZonas;
                this.listaZona = zonas;
            });
        },
        TraerFamilia1() {
            store.dispatch("TraerFamilia1").then(() => {
                let fam1 = store.getters.getFAM1;
                this.listaTempFamilia1 = fam1;
            });
        },
        TraerFamilia2() {
            store.dispatch("TraerFamilia2").then(() => {
                let fam2 = store.getters.getFAM2;
                this.listaTempFamilia2 = fam2;
            });
        },
        TraerFamilia3() {
            store.dispatch("TraerFamilia3").then(() => {
                let fam3 = store.getters.getFAM3;
                this.listaTempFamilia3 = fam3;
            });
        },
        TraerFamilia4() {
            store.dispatch("TraerFamilia4").then(() => {
                let fam4 = store.getters.getFAM4;
                this.listaTempFamilia4 = fam4;
            });
        },
        TraerFamilia5() {
            store.dispatch("TraerFamilia5").then(() => {
                let fam5 = store.getters.getFAM5;
                this.listaTempFamilia5 = fam5;
            });
        },
        //Metodos para Agregar Datos
        AgregarListaPresupuesto(
            codart,
            nombre,
            unimed,
            precio,
            idEstado,
            idBodega
        ) {
            try {
                let data = {
                    CODART: codart,
                    NOMBRE: nombre,
                    UNIMED: unimed,
                    PRECIO: parseFloat(precio),
                    PRE_PROM: parseFloat(precio),
                    idEstado: idEstado,
                    idBodega: idBodega
                };

                const dat = data;

                axios
                    .post(
                        this.externalVal + "/api/Mantenedor/PostArticulos",
                        dat,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` +
                                    localStorage.getItem("token_externo")
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
                                    "Articulo Registrado Correctamente En Plan Anual",
                                color: "success",
                                position: "top-right"
                            });
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible registrar el articulo,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        ModificarArticuloExterno(
            codart,
            nombre,
            unimed,
            precio,
            idEstado,
            idBodega
        ) {
            try {
                let data = {
                    CODART: codart,
                    NOMBRE: nombre,
                    UNIMED: unimed,
                    PRECIO: parseFloat(precio),
                    PRE_PROM: parseFloat(precio),
                    idEstado: idEstado,
                    idBodega: idBodega
                };

                const dat = data;

                axios
                    .post(
                        this.externalVal +
                            "/api/Mantenedor/PutArticulosExterno",
                        dat,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` +
                                    localStorage.getItem("token_externo")
                            }
                        }
                    )
                    .then(res => {
                        const solicitudServer = res.data;
                        if (solicitudServer == true) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text: "Articulo Modificado Correctamente En PA",
                                color: "success",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarArticulosGenerales() {
            try {
                if (this.seleccionBodega.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar una bodega",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionFamilia1.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar una familia",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.codigoBarra == "" || this.codigoBarra == null) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un codigo de barra",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.codigoArticulo == "" ||
                    this.codigoArticulo == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un codigo de articulo",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.nombre == "" || this.nombre == null) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un nombre de articulo",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.unidadMedidaBase == "" ||
                    this.unidadMedidaBase == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar una unidad de medida base",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionFechaVenciminento.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe selecciona una fecha de vencimiento",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionLoteSerie.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar una fecha de lote/serie",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.cantidadEmbalaje < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingregar una cantidad de embalaje",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let boolFVen = false;
                    if (this.seleccionFechaVenciminento.id == 1) {
                        boolFVen = true;
                    }

                    let boolFLoteSerie = false;
                    if (this.seleccionLoteSerie.id == 1) {
                        boolFLoteSerie = true;
                    }

                    if (this.image !== null) {
                        let imagen = new FormData();
                        //Añadimos la imagen seleccionada
                        imagen.append("avatar", this.image);
                        imagen.append("nombreDocOriginal", this.nombrearchivo);

                        axios
                            .post(
                                this.localVal + "/api/Mantenedor/PostImagen",
                                imagen,
                                {
                                    headers: {
                                        "Content-Type": "multipart/form-data",
                                        Authorization:
                                            `Bearer ` +
                                            localStorage.getItem("token")
                                    }
                                }
                            )
                            .then(res => {
                                const url = res.data;
                                if (url.length > 0) {
                                    let data = {
                                        CODART_BARR: this.codigoBarra.toUpperCase(),
                                        CODART_ONU: this.codigoOnu.toUpperCase(),
                                        CODART: this.codigoArticulo.toUpperCase(),
                                        NOMBRE: this.nombre.toUpperCase(),
                                        idEstado: this.seleccionEstado.id,
                                        ACT_FECVEN: boolFVen,
                                        ACT_LOTE: boolFLoteSerie,
                                        CANTXENB: this.cantidadEmbalaje,
                                        idBodega: this.seleccionBodega.id,
                                        idZona: this.seleccionZona.id,
                                        SECTOR: this.sector.toUpperCase(),
                                        UBICACION: this.ubicacion.toUpperCase(),
                                        NOMFAM1: this.seleccionFamilia1
                                            .descripcionFamilia,
                                        NOMFAM2: this.seleccionFamilia2
                                            .descripcionFamilia,
                                        NOMFAM3: this.seleccionFamilia3
                                            .descripcionFamilia,
                                        NOMFAM4: this.seleccionFamilia4
                                            .descripcionFamilia,
                                        NOMFAM5: this.seleccionFamilia5
                                            .descripcionFamilia,
                                        UNIMEDBASE: this.unidadMedidaBase.toUpperCase(),
                                        NOMARCH: url,
                                        PRECIO_BASE: this.precio_base
                                    };
                                    axios
                                        .post(
                                            this.localVal +
                                                "/api/Mantenedor/PostArticuloGeneral",
                                            data,
                                            {
                                                headers: {
                                                    Authorization:
                                                        `Bearer ` +
                                                        localStorage.getItem(
                                                            "token"
                                                        )
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
                                                        "Articulo Ingresado Correctamente",
                                                    color: "success",
                                                    position: "top-right"
                                                });
                                                this.AgregarListaPresupuesto(
                                                    this.codigoArticulo,
                                                    this.nombre.toUpperCase(),
                                                    this.unidadMedidaBase.toUpperCase(),
                                                    this.precio_base,
                                                    this.seleccionEstado.id,
                                                    this.seleccionBodega.id
                                                );
                                                this.limpiarCampos();
                                                this.popUpArticuloGeneral = false;
                                                this.TraerProductos();
                                                this.cargaItemBodega();
                                                setTimeout(() => {
                                                    this.cargaItemBodegaFamilia();
                                                }, 1000);
                                            } else {
                                                this.$vs.notify({
                                                    time: 5000,
                                                    title: "Error",
                                                    text:
                                                        "No fue posible registrar el Economato,intentelo nuevamente",
                                                    color: "danger",
                                                    position: "top-right"
                                                });
                                            }
                                        });
                                } else {
                                    this.$vs.notify({
                                        time: 5000,
                                        title: "Error",
                                        text:
                                            "No fue posible registrar el Articulo,intentelo nuevamente",
                                        color: "danger",
                                        position: "top-right"
                                    });
                                }
                            });
                    } else {
                        let data = {
                            CODART_BARR: this.codigoBarra.toUpperCase(),
                            CODART_ONU: this.codigoOnu.toUpperCase(),
                            CODART: this.codigoArticulo.toUpperCase(),
                            NOMBRE: this.nombre.toUpperCase(),
                            idEstado: this.seleccionEstado.id,
                            ACT_FECVEN: boolFVen,
                            ACT_LOTE: boolFLoteSerie,
                            CANTXENB: this.cantidadEmbalaje,
                            idBodega: this.seleccionBodega.id,
                            idZona: this.seleccionZona.id,
                            SECTOR: this.sector.toUpperCase(),
                            UBICACION: this.ubicacion.toUpperCase(),
                            NOMFAM1: this.seleccionFamilia1.descripcionFamilia,
                            NOMFAM2: this.seleccionFamilia2.descripcionFamilia,
                            NOMFAM3: this.seleccionFamilia3.descripcionFamilia,
                            NOMFAM4: this.seleccionFamilia4.descripcionFamilia,
                            NOMFAM5: this.seleccionFamilia5.descripcionFamilia,
                            UNIMEDBASE: this.unidadMedidaBase.toUpperCase(),
                            PRECIO_BASE: this.precio_base
                        };

                        axios
                            .post(
                                this.localVal +
                                    "/api/Mantenedor/PostArticuloGeneral",
                                data,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            localStorage.getItem("token")
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
                                            "Articulo Ingresado Correctamente",
                                        color: "success",
                                        position: "top-right"
                                    });
                                    this.AgregarListaPresupuesto(
                                        this.codigoArticulo,
                                        this.nombre.toUpperCase(),
                                        this.unidadMedidaBase.toUpperCase(),
                                        this.precio_base,
                                        this.seleccionEstado.id,
                                        this.seleccionBodega.id
                                    );
                                    this.limpiarCampos();
                                    this.popUpArticuloGeneral = false;
                                    this.TraerProductos();
                                    this.cargaItemBodega();
                                    setTimeout(() => {
                                        this.cargaItemBodegaFamilia();
                                    }, 1000);
                                } else {
                                    this.$vs.notify({
                                        time: 5000,
                                        title: "Error",
                                        text:
                                            "No fue posible registrar el Articulo,intentelo nuevamente",
                                        color: "danger",
                                        position: "top-right"
                                    });
                                }
                            });
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },
        ModificarArticulosGenerales() {
            try {
                if (this.seleccionBodega.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar una bodega",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionFamilia1.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar una familia",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.codigoBarra == "" || this.codigoBarra == null) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un codigo de barra",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.codigoArticulo == "" ||
                    this.codigoArticulo == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un codigo de articulo",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.nombre == "" || this.nombre == null) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un nombre de articulo",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.unidadMedidaBase == "" ||
                    this.unidadMedidaBase == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar una unidad de medida base",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionFechaVenciminento.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe selecciona una fecha de vencimiento",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionLoteSerie.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar una fecha de lote/serie",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.cantidadEmbalaje < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingregar una cantidad de embalaje",
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

                    if (this.image !== null) {
                        let imagen = new FormData();
                        //Añadimos la imagen seleccionada
                        imagen.append("avatar", this.image);
                        imagen.append("nombreDocOriginal", this.nombrearchivo);

                        axios
                            .post(
                                this.localVal + "/api/Mantenedor/PostImagen",
                                imagen,
                                {
                                    headers: {
                                        "Content-Type": "multipart/form-data",
                                        Authorization:
                                            `Bearer ` +
                                            localStorage.getItem("token")
                                    }
                                }
                            )
                            .then(res => {
                                const url = res.data;
                                if (url.length > 0) {
                                    let Acovid = false;
                                    if (this.seleccionCovid.id == 1) {
                                        Acovid = true;
                                    } else {
                                        Acovid = false;
                                    }
                                    let data = {
                                        id: this.idMod,
                                        CODART_BARR: this.codigoBarra.toUpperCase(),
                                        CODART_ONU: this.codigoOnu.toUpperCase(),
                                        CODART: this.codigoArticulo.toUpperCase(),
                                        NOMBRE: this.nombre.toUpperCase(),
                                        idEstado: this.seleccionEstado.id,
                                        ACT_FECVEN: boolFVen,
                                        ACT_LOTE: boolFLoteSerie,
                                        CANTXENB: this.cantidadEmbalaje,
                                        idBodega: this.seleccionBodega.id,
                                        idZona: this.seleccionZona.id,
                                        SECTOR: this.sector.toUpperCase(),
                                        UBICACION: this.ubicacion.toUpperCase(),
                                        NOMFAM1: this.seleccionFamilia1
                                            .descripcionFamilia,
                                        NOMFAM2: this.seleccionFamilia2
                                            .descripcionFamilia,
                                        NOMFAM3: this.seleccionFamilia3
                                            .descripcionFamilia,
                                        NOMFAM4: this.seleccionFamilia4
                                            .descripcionFamilia,
                                        NOMFAM5: this.seleccionFamilia5
                                            .descripcionFamilia,
                                        UNIMEDBASE: this.unidadMedidaBase.toUpperCase(),
                                        NOMARCH: url,
                                        COVID: Acovid,
                                        PRECIO_BASE: this.precio_base
                                    };
                                    const dat = data;
                                    axios
                                        .post(
                                            this.localVal +
                                                "/api/Mantenedor/PutArticuloGeneral",
                                            dat,
                                            {
                                                headers: {
                                                    Authorization:
                                                        `Bearer ` +
                                                        localStorage.getItem(
                                                            "token"
                                                        )
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
                                                        "Articulo Modificado Correctamente",
                                                    color: "success",
                                                    position: "top-right"
                                                });
                                                this.ModificarArticuloExterno(
                                                    this.codigoArticulo,
                                                    this.nombre.toUpperCase(),
                                                    this.unidadMedidaBase.toUpperCase(),
                                                    this.precio_base,
                                                    this.seleccionEstado.id,
                                                    this.seleccionBodega.id
                                                );
                                                this.limpiarCampos();
                                                this.popUpArticuloGeneralMod = false;
                                                this.TraerProductos();
                                                this.cargaItemBodega();
                                                setTimeout(() => {
                                                    this.cargaItemBodegaFamilia();
                                                }, 1000);
                                            } else {
                                                this.$vs.notify({
                                                    time: 5000,
                                                    title: "Error",
                                                    text:
                                                        "No fue posible Modificar el Articulo,intentelo nuevamente",
                                                    color: "danger",
                                                    position: "top-right"
                                                });
                                            }
                                        });
                                } else {
                                    this.$vs.notify({
                                        time: 5000,
                                        title: "Error",
                                        text:
                                            "No fue posible Modificar el Articulo,intentelo nuevamente",
                                        color: "danger",
                                        position: "top-right"
                                    });
                                }
                            });
                    } else {
                        let Acovid = false;
                        if (this.seleccionCovid.id == 1) {
                            Acovid = true;
                        } else {
                            Acovid = false;
                        }
                        let data = {
                            id: this.idMod,
                            CODART_BARR: this.codigoBarra.toUpperCase(),
                            CODART_ONU: this.codigoOnu.toUpperCase(),
                            CODART: this.codigoArticulo.toUpperCase(),
                            NOMBRE: this.nombre.toUpperCase(),
                            idEstado: this.seleccionEstado.id,
                            ACT_FECVEN: boolFVen,
                            ACT_LOTE: boolFLoteSerie,
                            CANTXENB: this.cantidadEmbalaje,
                            idBodega: this.seleccionBodega.id,
                            idZona: this.seleccionZona.id,
                            SECTOR: this.sector.toUpperCase(),
                            UBICACION: this.ubicacion.toUpperCase(),
                            NOMFAM1: this.seleccionFamilia1.descripcionFamilia,
                            NOMFAM2: this.seleccionFamilia2.descripcionFamilia,
                            NOMFAM3: this.seleccionFamilia3.descripcionFamilia,
                            NOMFAM4: this.seleccionFamilia4.descripcionFamilia,
                            NOMFAM5: this.seleccionFamilia5.descripcionFamilia,
                            UNIMEDBASE: this.unidadMedidaBase.toUpperCase(),
                            NOMARCH: null,
                            COVID: Acovid,
                            PRECIO_BASE: this.precio_base
                        };
                        axios
                            .post(
                                this.localVal +
                                    "/api/Mantenedor/PutArticuloGeneral",
                                data,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            localStorage.getItem("token")
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
                                            "Articulo Modificado Correctamente",
                                        color: "success",
                                        position: "top-right"
                                    });
                                    this.ModificarArticuloExterno(
                                        this.codigoArticulo,
                                        this.nombre.toUpperCase(),
                                        this.unidadMedidaBase.toUpperCase(),
                                        this.precio_base,
                                        this.seleccionEstado.id,
                                        this.seleccionBodega.id
                                    );
                                    this.limpiarCampos();
                                    this.popUpArticuloGeneral = false;
                                    this.TraerProductos();
                                    this.cargaItemBodega();
                                    setTimeout(() => {
                                        this.cargaItemBodegaFamilia();
                                    }, 1000);
                                } else {
                                    this.$vs.notify({
                                        time: 5000,
                                        title: "Error",
                                        text:
                                            "No fue posible Modificar el Articulo,intentelo nuevamente",
                                        color: "danger",
                                        position: "top-right"
                                    });
                                }
                            });
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },
        AgregarCodArticulosGenerales() {
            try {
                let validarCodigoBarra = false;
                let g = this.listaCodNuevo;

                g.forEach((value, index) => {
                    if (this.codigoBarra == value.CODART_BARR) {
                        validarCodigoBarra = true;
                    }
                });

                if (this.seleccionBodega.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar una bodega",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionFamilia1.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar una familia",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.codigoBarra == "" || this.codigoBarra == null) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un codigo de barra",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.codigoArticulo == "" ||
                    this.codigoArticulo == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un codigo de articulo",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.nombre == "" || this.nombre == null) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un nombre de articulo",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.unidadMedidaBase == "" ||
                    this.unidadMedidaBase == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar una unidad de medida base",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionFechaVenciminento.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe selecciona una fecha de vencimiento",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionLoteSerie.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar una fecha de lote/serie",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.cantidadEmbalaje < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingregar una cantidad de embalaje",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (validarCodigoBarra == true) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Codigo de barra repetido,ingrese otro codigo",
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
                    let Acovid = false;
                    if (this.seleccionCovid.id == 1) {
                        Acovid = true;
                    } else {
                        Acovid = false;
                    }
                    let data = {
                        CODART_BARR: this.codigoBarra.toUpperCase(),
                        CODART_ONU: this.codigoOnu.toUpperCase(),
                        CODART: this.codigoArticulo.toUpperCase(),
                        NOMBRE: this.nombre.toUpperCase(),
                        idEstado: this.seleccionEstado.id,
                        ACT_FECVEN: boolFVen,
                        ACT_LOTE: boolFLoteSerie,
                        CANTXENB: this.cantidadEmbalaje,
                        idBodega: this.seleccionBodega.id,
                        idZona: this.seleccionZona.id,
                        SECTOR: this.sector.toUpperCase(),
                        UBICACION: this.ubicacion.toUpperCase(),
                        NOMFAM1: this.seleccionFamilia1.descripcionFamilia,
                        NOMFAM2: this.seleccionFamilia2.descripcionFamilia,
                        NOMFAM3: this.seleccionFamilia3.descripcionFamilia,
                        NOMFAM4: this.seleccionFamilia4.descripcionFamilia,
                        NOMFAM5: this.seleccionFamilia5.descripcionFamilia,
                        UNIMEDBASE: this.unidadMedidaBase.toUpperCase(),
                        COVID: Acovid
                    };
                    const dat = data;
                    axios
                        .post(
                            this.localVal +
                                "/api/Mantenedor/PostCodArticuloGeneral",
                            dat,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
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
                                        "Codigo Articulo Ingresado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.TraerProductos();
                                this.cargaItemBodega();
                                setTimeout(() => {
                                    this.cargaItemBodegaFamilia();
                                }, 1000);
                                this.TraerDetalleByCodInterno(
                                    this.codigoArticulo
                                );
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible agregar el codigo de articulo,intentelo nuevamente",
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
        //Metodos CRUD Medicamentos
        AgregarMedicamento() {
            try {
                if (this.seleccionBodega.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "Debe seleccionar una bodega, Revise y intente nuevamente",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionLaboratorio.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "Debe seleccionar un laboratorio, Revise y intente nuevamente",
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

                    if (this.image !== null) {
                        let imagen = new FormData();
                        //Añadimos la imagen seleccionada
                        imagen.append("avatar", this.image);
                        imagen.append("nombreDocOriginal", this.nombrearchivo);

                        axios
                            .post(
                                this.localVal + "/api/Mantenedor/PostImagen",
                                imagen,
                                {
                                    headers: {
                                        "Content-Type": "multipart/form-data",
                                        Authorization:
                                            `Bearer ` +
                                            localStorage.getItem("token")
                                    }
                                }
                            )
                            .then(res => {
                                const url = res.data;
                                if (url.length > 0) {
                                    let Acovid = false;
                                    if (this.seleccionCovid.id == 1) {
                                        Acovid = true;
                                    } else {
                                        Acovid = false;
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
                                        LABORATORIO: this.seleccionLaboratorio.LABORATORIO.toUpperCase(),
                                        CANTXENB: this.cantidadEmbalaje,
                                        idBodega: this.seleccionBodega.id,
                                        idZona: this.seleccionZona.id,
                                        SECTOR: this.sector.toUpperCase(),
                                        UBICACION: this.ubicacion.toUpperCase(),
                                        ZGEN: this.zgen.toUpperCase(),
                                        NOMARCH: url,
                                        COVID: Acovid,
                                        PRECIO_BASE: this.precio_base
                                    };

                                    const dat = data;

                                    axios
                                        .post(
                                            this.localVal +
                                                "/api/Mantenedor/PostArticuloGeneral",
                                            dat,
                                            {
                                                headers: {
                                                    Authorization:
                                                        `Bearer ` +
                                                        localStorage.getItem(
                                                            "token"
                                                        )
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
                                                        "Medicamento Ingresado Correctamente",
                                                    color: "success",
                                                    position: "top-right"
                                                });
                                                this.AgregarListaPresupuesto(
                                                    this.codigoArticulo,
                                                    this.nombre.toUpperCase(),
                                                    this.unidadMedidaBase.toUpperCase(),
                                                    this.precio_base,
                                                    this.seleccionEstado.id,
                                                    this.seleccionBodega.id
                                                );
                                                this.popUpMedicamento = false;
                                                this.TraerProductos();
                                                setTimeout(() => {
                                                    this.cargaItemBodegaFamilia();
                                                }, 1000);
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
                                } else {
                                    this.$vs.notify({
                                        time: 5000,
                                        title: "Error",
                                        text:
                                            "No fue posible registrar el Insumo/Economato,intentelo nuevamente",
                                        color: "danger",
                                        position: "top-right"
                                    });
                                }
                            });
                    } else {
                        let Acovid = false;
                        if (this.seleccionCovid.id == 1) {
                            Acovid = true;
                        } else {
                            Acovid = false;
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
                            LABORATORIO: this.seleccionLaboratorio.LABORATORIO.toUpperCase(),
                            CANTXENB: this.cantidadEmbalaje,
                            idBodega: this.seleccionBodega.id,
                            idZona: this.seleccionZona.id,
                            SECTOR: this.sector.toUpperCase(),
                            UBICACION: this.ubicacion.toUpperCase(),
                            ZGEN: this.zgen.toUpperCase(),
                            COVID: Acovid,
                            PRECIO_BASE: this.precio_base
                        };

                        const dat = data;

                        axios
                            .post(
                                this.localVal +
                                    "/api/Mantenedor/PostArticuloGeneral",
                                dat,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            localStorage.getItem("token")
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
                                            "Medicamento Ingresado Correctamente",
                                        color: "success",
                                        position: "top-right"
                                    });
                                    this.AgregarListaPresupuesto(
                                        this.codigoArticulo,
                                        this.nombre.toUpperCase(),
                                        this.unidadMedidaBase.toUpperCase(),
                                        this.precio_base,
                                        this.seleccionEstado.id,
                                        this.seleccionBodega.id
                                    );
                                    this.popUpMedicamento = false;
                                    this.TraerProductos();
                                    setTimeout(() => {
                                        this.cargaItemBodegaFamilia();
                                    }, 1000);
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
                        text:
                            "Debe seleccionar una bodega, Revise y intente nuevamente",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.seleccionLaboratorio.id == 0) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "Debe seleccionar un laboratorio, Revise y intente nuevamente",
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

                    if (this.image !== null) {
                        let imagen = new FormData();
                        //Añadimos la imagen seleccionada
                        imagen.append("avatar", this.image);
                        imagen.append("nombreDocOriginal", this.nombrearchivo);

                        axios
                            .post(
                                this.localVal + "/api/Mantenedor/PostImagen",
                                imagen,
                                {
                                    headers: {
                                        "Content-Type": "multipart/form-data",
                                        Authorization:
                                            `Bearer ` +
                                            localStorage.getItem("token")
                                    }
                                }
                            )
                            .then(res => {
                                const url = res.data;
                                if (url.length > 0) {
                                    let Acovid = false;
                                    if (this.seleccionCovid.id == 1) {
                                        Acovid = true;
                                    } else {
                                        Acovid = false;
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
                                        LABORATORIO: this.seleccionLaboratorio.LABORATORIO.toUpperCase(),
                                        CANTXENB: this.cantidadEmbalaje,
                                        idBodega: this.seleccionBodega.id,
                                        idZona: this.seleccionZona.id,
                                        SECTOR: this.sector.toUpperCase(),
                                        UBICACION: this.ubicacion.toUpperCase(),
                                        ZGEN: this.zgen.toUpperCase(),
                                        NOMARCH: url,
                                        COVID: Acovid,
                                        PRECIO_BASE: this.precio_base
                                    };

                                    const dat = data;

                                    axios
                                        .post(
                                            this.localVal +
                                                "/api/Mantenedor/PutMedicamentos",
                                            dat,
                                            {
                                                headers: {
                                                    Authorization:
                                                        `Bearer ` +
                                                        localStorage.getItem(
                                                            "token"
                                                        )
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
                                                this.ModificarArticuloExterno(
                                                    this.codigoArticulo,
                                                    this.nombre.toUpperCase(),
                                                    this.unidadMedidaBase.toUpperCase(),
                                                    this.precio_base,
                                                    this.seleccionEstado.id,
                                                    this.seleccionBodega.id
                                                );
                                                this.popUpMedicamentoMod = false;
                                                this.TraerProductos();
                                                setTimeout(() => {
                                                    this.cargaItemBodegaFamilia();
                                                }, 1000);
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
                                } else {
                                    this.$vs.notify({
                                        time: 5000,
                                        title: "Error",
                                        text:
                                            "No fue posible registrar el Insumo/Economato,intentelo nuevamente",
                                        color: "danger",
                                        position: "top-right"
                                    });
                                }
                            });
                    } else {
                        let Acovid = false;
                        if (this.seleccionCovid.id == 1) {
                            Acovid = true;
                        } else {
                            Acovid = false;
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
                            LABORATORIO: this.seleccionLaboratorio.LABORATORIO.toUpperCase(),
                            CANTXENB: this.cantidadEmbalaje,
                            idBodega: this.seleccionBodega.id,
                            idZona: this.seleccionZona.id,
                            SECTOR: this.sector.toUpperCase(),
                            UBICACION: this.ubicacion.toUpperCase(),
                            ZGEN: this.zgen.toUpperCase(),
                            NOMARCH: null,
                            COVID: Acovid,
                            PRECIO_BASE: this.precio_base
                        };

                        const dat = data;

                        axios
                            .post(
                                this.localVal +
                                    "/api/Mantenedor/PutMedicamentos",
                                dat,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            localStorage.getItem("token")
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
                                    this.ModificarArticuloExterno(
                                        this.codigoArticulo,
                                        this.nombre.toUpperCase(),
                                        this.unidadMedidaBase.toUpperCase(),
                                        this.precio_base,
                                        this.seleccionEstado.id,
                                        this.seleccionBodega.id
                                    );
                                    this.popUpMedicamentoMod = false;
                                    this.TraerProductos();
                                    setTimeout(() => {
                                        this.cargaItemBodegaFamilia();
                                    }, 1000);
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
                                    `Bearer ` + localStorage.getItem("token")
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
                                    "Codigo de barra ya ingresado,intente con otro codigo",
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
                let validarCodigoBarra = false;
                let g = this.listaCodNuevo;

                g.forEach((value, index) => {
                    if (this.codigoBarra == value.CODART_BARR) {
                        validarCodigoBarra = true;
                    }
                });

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
                let Acovid = false;
                if (this.seleccionCovid.id == 1) {
                    Acovid = true;
                } else {
                    Acovid = false;
                }

                if (validarCodigoBarra == true) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "Codigo de barra ya ingresado,intente con otro codigo",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
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
                        LABORATORIO: this.seleccionLaboratorio.LABORATORIO.toUpperCase(),
                        CANTXENB: this.cantidadEmbalaje,
                        idBodega: this.seleccionBodega.id,
                        idZona: this.seleccionZona.id,
                        SECTOR: this.sector.toUpperCase(),
                        UBICACION: this.ubicacion.toUpperCase(),
                        ZGEN: this.zgen.toUpperCase(),
                        COVID: Acovid
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal +
                                "/api/Mantenedor/PostCodArticuloGeneral",
                            dat,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        localStorage.getItem("token")
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
                                this.TraerProductos();
                                setTimeout(() => {
                                    this.cargaItemBodegaFamilia();
                                }, 1000);
                                this.TraerDetalleByCodInterno(
                                    this.codigoArticulo
                                );
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
        ModificarCodigoBarra() {
            try {
                let data = {
                    id: this.idMod,
                    CODART_BARR: this.codigoBarraOriginal,
                    CODART: this.codigoArticulo,
                    CODART_BAR: this.codigoBarra
                };

                axios
                    .post(
                        this.localVal + "/api/Mantenedor/PutCodigoBarra",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
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
                                    "Codigo Modificado Agregado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.TraerDetalleByCodInterno(this.codigoArticulo);
                            this.popUpModificarCodigo = false;
                            if (this.codMedEcoIns == 1) {
                                this.popUpNCMedicamento = true;
                            } else {
                                this.popUpCodArticuloGeneral = true;
                            }
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible modificar el codigo,intentelo nuevamente",
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
        setTimeout(() => {
            //this.TraerProductos();
            this.TraerEstado();
            this.TraerLaboratorios();
            this.TraerBodega();
            this.TraerZona();
            this.TraerFamilia1();
            this.TraerFamilia2();
            this.TraerFamilia3();
            this.TraerFamilia4();
            this.TraerFamilia5();
            this.openLoadingColor();
        }, 2000);
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1500px;
}
</style>
