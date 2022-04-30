import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MainPageComponent } from './pages/main-page/main-page.component';
import { LoginComponent } from './components/login/login.component';
import { FormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';
import { HttpClientModule } from '@angular/common/http';

@NgModule({
  declarations: [MainPageComponent, LoginComponent],
  imports: [CommonModule, FormsModule, RouterModule, HttpClientModule],
  exports: [MainPageComponent],
})
export class HomeModule {}
