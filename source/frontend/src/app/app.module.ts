import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FlexLayoutModule } from '@angular/flex-layout';

import { AdminRoutesModule } from './admin-route.module';

import { AdminComponent } from './components/admin.component';

@NgModule({
  declarations: [
    AdminComponent,
  ],
  imports: [
    BrowserModule,
    AdminRoutesModule,
    FlexLayoutModule,

  ],
  providers: [],
  bootstrap: [ AdminComponent ]
})
export class AdminModule {
}
