<template>
    <div>
        <vx-card title="Insumo/Economato">
            <div>
                <vs-button
                    color="primary"
                    type="filled"
                    @click="popInsumoEconomato"
                    >Agregar Insumo/Economato</vs-button
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
                                    content="Modificar Insumo/Economato"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popInsumoEconomatoMod(
                                            props.row.id,
                                            props.row.NOMBRE,
                                            props.row.UNIMEDBASE,
                                            props.row.CODART_ONU,
                                            props.row.CODART,
                                            props.row.CODART_BARR,
                                            props.row.idEstado,
                                            props.row.UBICACION,
                                            props.row.SECTOR,
                                            props.row.idBodega,
                                            props.row.idZona,
                                            props.row.CANTXENB,
                                            props.row.NOMFAM1,
                                            props.row.NOMFAM2,
                                            props.row.NOMFAM3,
                                            props.row.NOMFAM4,
                                            props.row.NOMFAM5,
                                            props.row.idACT_FECVEN,
                                            props.row.idACTLOTE
                                        )
                                    "
                                ></plus-circle-icon>
                                <plus-circle-icon
                                    content="Agregar Codigo Insumo/Economato"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popCodInsumoEconomato(
                                            props.row.NOMBRE,
                                            props.row.UNIMEDBASE,
                                            props.row.CODART_ONU,
                                            props.row.CODART,
                                            props.row.CODART_BARR,
                                            props.row.idEstado,
                                            props.row.UBICACION,
                                            props.row.SECTOR,
                                            props.row.idBodega,
                                            props.row.idZona,
                                            props.row.CANTXENB,
                                            props.row.NOMFAM1,
                                            props.row.NOMFAM2,
                                            props.row.NOMFAM3,
                                            props.row.NOMFAM4,
                                            props.row.NOMFAM5,
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
            <!-- Agregar -->
            <vs-popup
                classContent="AgregarInsumoEco"
                title="Agregar Insumo/Economato"
                :active.sync="popUpInsumoEco"
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
                        </div>
                        <br />
                        <div class="vx-row w-full">
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="popUpInsumoEco = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="AgregarInsumoEco"
                                    color="success"
                                    type="filled"
                                    class="w-full"
                                    >Agregar Insumo/Economato</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <!-- Modificar -->
            <vs-popup
                classContent="InsumoEcoMod"
                title="Modificar Insumo/Economato"
                :active.sync="popUpInsumoEcoMod"
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
                        </div>
                        <br />
                        <div class="vx-row w-full">
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="popUpInsumoEcoMod = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="ModificarInsumoEco"
                                    color="success"
                                    type="filled"
                                    class="w-full"
                                    >Modificar Insumo/Economato</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <!-- Codigo Articulo -->
            <vs-popup
                classContent="InsumoEcoMod"
                title="Agregar Codigo Insumo/Economato"
                :active.sync="popUpCodInsumoEco"
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
                                    disabled
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Codigo Interno</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="codigoArticulo"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Nombre Articulo</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="nombre"
                                    disabled
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
                                    disabled
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
                                    disabled
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
                                    disabled
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
                                    disabled
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
                                    disabled
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Unidad Medida Base</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="unidadMedidaBase"
                                    disabled
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
                                    disabled
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
                                    disabled
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
                                    disabled
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Cantidad Embalaje</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="cantidadEmbalaje"
                                    disabled
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
                                    disabled
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Sector</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="sector"
                                    disabled
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Ubicacion</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="ubicacion"
                                    disabled
                                />
                            </div>
                        </div>
                        <br />
                        <div class="vx-row w-full">
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="popUpCodInsumoEco = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <vs-button
                                    @click="AgregarCodInsumoEco"
                                    color="success"
                                    type="filled"
                                    class="w-full"
                                    >Agregar Codigo Insumo/Economato</vs-button
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
            popUpInsumoEco: false,
            popUpInsumoEcoMod: false,
            popUpCodInsumoEco: false,
            codigoBarra: "",
            codigoOnu: "",
            codigoArticulo: "",
            nombre: "",
            idEstado: "",
            actFechaVencimiento: false,
            actLoteSerie: false,
            cantidadEmbalaje: "",
            idBodega: "",
            idZona: "",
            sector: "",
            ubicacion: "",
            unidadMedidaBase: "",
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
                    label: "Bodega",
                    field: "descripcionBodega",
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
                    label: "Unidad de Medida",
                    field: "UNIMEDBASE",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Descripcion Familia 1",
                    field: "NOMFAM1",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Descripcion Familia 2",
                    field: "NOMFAM2",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Descripcion Familia 3",
                    field: "NOMFAM3",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Descripcion Familia 4",
                    field: "NOMFAM4",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Descripcion Familia 5",
                    field: "NOMFAM5",
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
            listaEstado: [],
            listaBodega: [],
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
                this.codigoOnu = "";
                this.codigoArticulo = "";
                this.nombre = "";
                this.seleccionEstado = {
                    id: 0,
                    descripcionEstado: ""
                };
                this.seleccionFechaVenciminento = {
                    id: 0,
                    descripcionFVen: "Seleccione Fecha Venciminento"
                };
                this.seleccionLoteSerie = {
                    id: 0,
                    descripcionLoteSerie: "Seleccione Lote/Serie"
                };
                this.cantidadEmbalaje = "";
                this.idBodega = 0;
                this.seleccionBodega = {
                    id: 0,
                    descripcionBodega: ""
                };
                this.idZona = 0;
                this.seleccionZona = {
                    id: 0,
                    descripcionZonas: ""
                };
                this.sector = "";
                this.ubicacion = "";
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
                this.unidadMedidaBase = "";
                this.idMod = 0;
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
        //PopUp
        popInsumoEconomato() {
            try {
                this.popUpInsumoEco = true;
                this.limpiarCampos();
            } catch (error) {
                console.log(error);
            }
        },
        popInsumoEconomatoMod(
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
            idACTLOTE
        ) {
            try {
                this.limpiarCampos();
                this.popUpInsumoEcoMod = true;
                this.idMod = id;
                this.codigoBarra = CODART_BARR;
                this.codigoOnu = CODART_ONU;
                this.codigoArticulo = CODART;
                this.nombre = NOMBRE;
                let c = this.listaEstado;

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
            } catch (error) {
                console.log(error);
            }
        },
        popCodInsumoEconomato(
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
            idACTLOTE
        ) {
            try {
                this.limpiarCampos();
                this.popUpCodInsumoEco = true;
                this.codigoBarra = CODART_BARR;
                this.codigoOnu = CODART_ONU;
                this.codigoArticulo = CODART;
                this.nombre = NOMBRE;
                let c = this.listaEstado;

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
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD Servicios
        TraerInsumoEconomato() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetInsumoEconomato", {
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
        AgregarInsumoEco() {
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
                    CODART_BARR: this.codigoBarra,
                    CODART_ONU: this.codigoOnu,
                    CODART: this.codigoArticulo,
                    NOMBRE: this.nombre,
                    idEstado: this.seleccionEstado.id,
                    ACT_FECVEN: boolFVen,
                    ACT_LOTE: boolFLoteSerie,
                    CANTXENB: this.cantidadEmbalaje,
                    idBodega: this.seleccionBodega.id,
                    idZona: this.seleccionZona.id,
                    SECTOR: this.sector,
                    UBICACION: this.ubicacion,
                    NOMFAM1: this.seleccionFamilia1.descripcionFamilia,
                    NOMFAM2: this.seleccionFamilia2.descripcionFamilia,
                    NOMFAM3: this.seleccionFamilia3.descripcionFamilia,
                    NOMFAM4: this.seleccionFamilia4.descripcionFamilia,
                    NOMFAM5: this.seleccionFamilia5.descripcionFamilia,
                    UNIMEDBASE: this.unidadMedidaBase
                };
                const dat = data;

                axios
                    .post(
                        this.localVal + "/api/Mantenedor/PostInsumoEconomato",
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
                                text:
                                    "Insumo/Economato Ingresado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.popUpInsumoEco = false;
                            this.TraerInsumoEconomato();
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
            } catch (error) {
                console.log(error);
            }
        },
        ModificarInsumoEco() {
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
                    id: this.idMod,
                    CODART_BARR: this.codigoBarra,
                    CODART_ONU: this.codigoOnu,
                    CODART: this.codigoArticulo,
                    NOMBRE: this.nombre,
                    idEstado: this.seleccionEstado.id,
                    ACT_FECVEN: boolFVen,
                    ACT_LOTE: boolFLoteSerie,
                    CANTXENB: this.cantidadEmbalaje,
                    idBodega: this.seleccionBodega.id,
                    idZona: this.seleccionZona.id,
                    SECTOR: this.sector,
                    UBICACION: this.ubicacion,
                    NOMFAM1: this.seleccionFamilia1.descripcionFamilia,
                    NOMFAM2: this.seleccionFamilia2.descripcionFamilia,
                    NOMFAM3: this.seleccionFamilia3.descripcionFamilia,
                    NOMFAM4: this.seleccionFamilia4.descripcionFamilia,
                    NOMFAM5: this.seleccionFamilia5.descripcionFamilia,
                    UNIMEDBASE: this.unidadMedidaBase
                };
                const dat = data;
                axios
                    .post(
                        this.localVal + "/api/Mantenedor/PutInsumoEconomato",
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
                                text:
                                    "Insumo/Economato Modificado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.TraerInsumoEconomato();
                            this.popUpInsumoEcoMod = false;
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible modificar el Insumo/Economato,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarCodInsumoEco() {
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
                    CODART_BARR: this.codigoBarra,
                    CODART_ONU: this.codigoOnu,
                    CODART: this.codigoArticulo,
                    NOMBRE: this.nombre,
                    idEstado: this.seleccionEstado.id,
                    ACT_FECVEN: boolFVen,
                    ACT_LOTE: boolFLoteSerie,
                    CANTXENB: this.cantidadEmbalaje,
                    idBodega: this.seleccionBodega.id,
                    idZona: this.seleccionZona.id,
                    SECTOR: this.sector,
                    UBICACION: this.ubicacion,
                    NOMFAM1: this.seleccionFamilia1.descripcionFamilia,
                    NOMFAM2: this.seleccionFamilia2.descripcionFamilia,
                    NOMFAM3: this.seleccionFamilia3.descripcionFamilia,
                    NOMFAM4: this.seleccionFamilia4.descripcionFamilia,
                    NOMFAM5: this.seleccionFamilia5.descripcionFamilia,
                    UNIMEDBASE: this.unidadMedidaBase
                };
                const dat = data;
                axios
                    .post(
                        this.localVal +
                            "/api/Mantenedor/PostCodInsumoEconomato",
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
                                text: "Codigo Insumo/Economato Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.TraerInsumoEconomato();
                            this.popUpCodInsumoEco = false;
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible agregar el codigo de Insumo/Economato,intentelo nuevamente",
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
        this.TraerInsumoEconomato();
        this.TraerEstado();
        this.TraerBodega();
        this.TraerZona();
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
