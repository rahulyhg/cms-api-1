import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { FormsModule } from '@angular/forms';
import { NgModule } from '@angular/core';
import { ElModule } from 'element-angular/release/element-angular.module';

import { adminRouting } from './admin-route.module';

import { AdminComponent } from './components/admin.component';
import { LoginFooterComponent } from './components/login-footer/login.footer.component';
import { LoginComponent } from './pages/login/login.component';
import { DashboardComponent } from './pages/dashboard/dashboard.component';
import { PageNotFoundComponent } from './pages/page-not-found/page-not-found.component';

import { EmailValidator } from './shared/email-validator.directive';
import { AuthGuard } from './shared/auth.guard';
import { AuthenticationService } from './services/authentication.service';
import { RegisterComponent } from './pages/register/register.component';
import { FooterComponent } from './components/footer/footer.component';
import { NavigationComponent } from './components/navigation/navigation.component';

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
