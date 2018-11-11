import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { HTTP_INTERCEPTORS } from '@angular/common/http';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { NgModule } from '@angular/core';
import { ElModule } from 'element-angular/release/element-angular.module';

import { adminRouting } from './admin.route';

import { AdminComponent } from './components/admin.component';
import { LoginFooterComponent } from './components/login-footer/login.footer.component';
import { LoginComponent } from './pages/login/login.component';
import { DashboardComponent } from './pages/dashboard/dashboard.component';
import { PageNotFoundComponent } from './pages/page-not-found/page-not-found.component';

import { AuthGuard } from './shared/auth.guard';
import { AuthService } from './services/auth.service';
import { RegisterComponent } from './pages/register/register.component';
import { FooterComponent } from './components/footer/footer.component';
import { NavigationComponent } from './components/navigation/navigation.component';
import { AlertComponent } from './components/alert/alert.component';
import { AuthInterceptor } from './shared/auth.interceptor';
import { UserService } from './services/user.service';
import { ErrorHandlingInterceptor } from './shared/error-handling.interceptor';

@NgModule({
  declarations: [
    AdminComponent,
    LoginComponent,
    LoginFooterComponent,
    RegisterComponent,
    DashboardComponent,
    PageNotFoundComponent,
    FooterComponent,
    NavigationComponent,
    AlertComponent,
  ],
  imports: [
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    adminRouting,
    ElModule,
    BrowserAnimationsModule,
  ],
  providers: [
    AuthGuard,
    AuthService,
    UserService,
    { provide: HTTP_INTERCEPTORS, useClass: AuthInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: ErrorHandlingInterceptor, multi: true },
  ],
  bootstrap: [ AdminComponent ]
})
export class AdminModule {
}
