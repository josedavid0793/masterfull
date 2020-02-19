//Imports necesarios
import {ModuleWithProviders} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';

//Importar componentes

import {LoginComponent} from './components/login/login.component';
import {RegisterComponent} from './components/register/register.component';
import { DefaultComponent } from './components/default/default.component';
import { ErrorComponent } from './components/error/error.component';


//definir rutas

const appRoutes: Routes = [
           {path:'', component:DefaultComponent},
           {path:'inicio', component: DefaultComponent},
           {path: 'login', component: LoginComponent},
           {path: 'registro', component: RegisterComponent},
           {path: '**', component: ErrorComponent},
];

//exportar todo para que se tome por parte ANGULAR

export const appRoutingProviders: any []=[];
export const routing: ModuleWithProviders = RouterModule.forRoot(appRoutes);