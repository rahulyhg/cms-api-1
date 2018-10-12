import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { FormsModule } from '@angular/forms';
import { NgModule } from '@angular/core';
import { ElModule } from 'element-angular/release/element-angular.module';

import { adminRouting } from './admin-route.module';

import { AdminComponent } from './components/admin.component';
import { LoginComponent } from './pages/login/login.component';
import { DashboardComponent } from './pages/dashboard/dashboard.component';
import { PageNotFoundComponent } from './pages/page-not-found/page-not-found.component';

import { EmailValidator } from './shared/email-validator.directive';

import { AuthGuard } from './services/auth-guard.service';
import { AuthenticationService } from './services/authentication.service';

@NgModule({
  declarations: [
    AdminComponent,
    LoginComponent,
    DashboardComponent,
    PageNotFoundComponent,
    EmailValidator,
  ],
  imports: [
    BrowserModule,
    FormsModule,
    adminRouting,
    ElModule,
    BrowserAnimationsModule,
  ],
  providers: [ AuthGuard, AuthenticationService ],
  bootstrap: [ AdminComponent ]
})
export class AdminModule {
}
