<template>
    <div v-if="user">
        <nav class="navbar navbar-expand navbar-light bg-white shadow-sm fixed-top px-4">
            <a v-if="user.permissions.includes('view collaborators')" id="navbar-toggler" @click="sidebar.active = !sidebar.active" :class="{ 'opacity-1': sidebar.active }">
                <i class="fas fa-align-left fa-2x"></i>
            </a>
            <a v-else href="#" class="text-dark d-flex align-items-center">
                <img src="@/assets/images/logo.svg" class="mr-2" width="50px" height="50px" alt="Satoripop logo">
                <div>
                    <h3 class="font-weight-bold m-0 line-height-100">satoripop</h3>
                    <h6 class="font-weight-bold text-secondary m-0 line-height-100">shine clever</h6>
                </div>
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto font-weight-bold">
                    <li class="nav-item">
                        <router-link v-if="user.role === 'Employee'" :to="{ name: 'profile', params: { id: user.id } }" class="nav-link clickable"><i class="fas fa-user"></i> Profile</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'settings' }" class="nav-link clickable"><i class="fas fa-cog"></i> Settings</router-link>
                    </li>
                    <li class="nav-item" @click="onLogout">
                        <a class="nav-link clickable" href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div v-if="user.permissions.includes('view collaborators')" id="sidebar" class="bg-dark text-light mt-5" :class="{ 'active': sidebar.active }">
            <div class="sidebar-header d-flex flex-column align-items-center px-3 pt-5 pb-4">
                <img :src="'http://localhost:8000/' + user.image_path" class="rect rounded-circle shadow mb-3" alt="Ala Baganné">
                <h3 class="font-weight-light text-warning mb-0">{{ user ? user.name : '' }}</h3>
                <h5 class="text-capitalize">{{ user.role }}</h5>
            </div>
            <div class="sidebar-links">
                <div id="accordion">
                    <a href="#" class="d-flex align-items-center" data-toggle="collapse" data-target="#drop1" aria-expanded="true" aria-controls="drop1">
                        <span class="mr-auto">Collaborators</span>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <div id="drop1" class="dropdown collapse show" data-parent="#accordion">
                        <router-link :to="{ name: 'dashboard' }">Dashboard</router-link>
                        <router-link :to="{ name: 'collaborators' }">Collaborators</router-link>
                        <router-link :to="{ name: 'archive' }">Archive</router-link>
                    </div>
                    <a href="#">Recruitments</a>
                    <a href="#">Tranings</a>
                    <a href="#">Evaluations & Careers</a>
                    <a href="#">Time & Activities</a>
                </div>
            </div>
        </div>
        <div class="bg-light min-vh-100 pt-5 px-4 pb-1 ">
            <div id="main" class="pt-5 d-flex flex-column" :class="{ 'push-right': sidebar.active }">
                <router-view class="mt-2 mx-3 mb-auto" />
                <footer class="mt-4 text-center">
                    <p>Designed and developped by <a href="#">Ala Baganné</a></p>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
export default {
    data() {
        return {
            sidebar: {
                active: true
            }
        }
    },
    computed: {
        ...mapGetters({
            user: 'auth/user'
        })
    },
    methods: {
        ...mapActions({
            logout: 'auth/logout' 
        }),
        onLogout() {
            this.logout().then(() => {
                this.$router.replace({ name: 'login' });
            });
        }
    },
    created() {
        if(!this.user.permissions.includes('view collaborators') || window.innerWidth <= "768") {
            this.sidebar.active = false;
        }
    }
}
</script>

<style lang="scss" scoped>
.navigation {
    position: fixed;
    top: 0;
    min-height: 100vh;
    width: 100%;
    z-index: 1;
}
nav {
    z-index: 20;
    #navbar-toggler {
        opacity: .6;
        padding: .5em;
        color: var(--secondary);
        cursor: pointer;
        &:hover {
            opacity: 1;
        }
    }
    .nav-link i {
        color: var(--primary);
    }
}
* {
    transition: .5s;
}
#sidebar {
    position: fixed;
    width: 320px;
    left: -320px;
    height: 100%;
    background-image: linear-gradient(rgba(4,4,4,.9) 0 100%), url('assets/images/2.jpg');
    background-size: cover;
    z-index: 10;
    .sidebar-header {
        border-bottom: 1px solid rgba(255,255,255,.4);
        background-color: rgba(0,0,0,.4);
    }
    &.active {
        left: 0;
    }
    a {
        display: block;
        padding: 1em;
        border-left: 1px solid transparent;
        border-bottom: 1px solid transparent;
        color: var(--light);
        &:hover, &.active, &[aria-expanded=true], &.router-link-exact-active {
            color: var(--warning);
            border-left-color: var(--warning);
            padding-left: 1.5em;
        }
        &[aria-expanded=false] i {
            transform: rotate(-90deg);
        }
        &[aria-expanded=true], &.router-link-exact-active {
            background-color: black;
        }
    }
    .dropdown {
        background-color: rgba(0,0,0,.6);
        a {
            color: rgba(255,255,255,.6);
            font-size: 10pt;
            &:hover, &.router-link-exact-active {
                background-color: rgba(0,0,0,.2);
                border-left-color: var(--light);
                color: var(--light);
            }
            
        }
    }
    a, .dropdown a {
        border-bottom-color: rgba(255,255,255,.2);
    }
}
#main.push-right {
    margin-left: 320px;
}
@media (max-width: 991.98px) {
    #main.push-right {
        margin-left: 0;
    }
}
@media (max-width: 575.98px) {
    #sidebar {
        width: 100%;
        left: -100%;
    }
}
</style>