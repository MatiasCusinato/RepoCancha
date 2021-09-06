<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
            <div class="container-fluid">
                <router-link to="/" class="navbar-brand">Inicio</router-link>
                
                <div class="collapse navbar-collapse">
                    <div class="navbar-nav">
                        <router-link to="/INFOturnosADMIN" class="nav-item nav-link">Turnos ADM</router-link>
                        <router-link to="/INFOclientes" class="nav-item nav-link">Clientes</router-link>
                        <router-link to="/INFOcanchas" class="nav-item nav-link">Canchas</router-link>
                    </div>
                </div>

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
    name: "NavigationBar",
}
</script>