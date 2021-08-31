<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
            <div class="container-fluid">
                <router-link to="/" class="navbar-brand">Inicio</router-link>
                <router-link to="/INFOclientes" class="navbar-brand"> Clientes </router-link>
                <router-link to="/INFOturnosADMIN" class="navbar-brand">TurnosADMIN</router-link>
                <router-link to="/INFOturnos" class="navbar-brand">TurnosDisponibles</router-link>
                <router-link to="/INFOcanchas" class="navbar-brand">Canchas</router-link>
                <router-link to="/INFOgaleria" class="navbar-brand">Galeria</router-link>
                <router-link to="/INFOsoporte" class="navbar-brand">Soporte</router-link>

                <div>
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <router-link to="/login" class="nav-link">Login</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/registro" class="nav-link">Registro</router-link>
                        </li>
                    </ul>

                    <!-- <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a href="#" class="nav-link">Logout</a>
                        </li>
                    </ul> -->
                </div>
            </div>
        </nav>
    </div>
</template>


<script>
export default {
    
}
</script>