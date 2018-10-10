import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FlexLayoutModule } from '@angular/flex-layout';

import { adminRouting } from './admin-route.module';

import { AdminComponent } from './components/admin.component';
import { LoginComponent } from "./pages/login/login.component";
import { DashboardComponent } from "./pages/dashboard/dashboard.component";
import { PageNotFoundComponent } from "./pages/page-not-found/page-not-found.component";
import { AuthGuard } from "./services/auth-guard";

@NgModule({
  declarations: [
    AdminComponent,
    LoginComponent,
    DashboardComponent,
    PageNotFoundComponent,
  ],
  imports: [
    BrowserModule,
    adminRouting,
    FlexLayoutModule,
  ],
  providers: [ AuthGuard ],
  bootstrap: [ AdminComponent ]
})
export class AdminModule {
}
