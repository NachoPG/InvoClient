import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ClientRoutingModule } from './client-routing.module';
import { ClientComponent } from './pages/main-page-client/client.component';
import { TableClientsComponent } from './components/table-clients/table-clients.component';
import { NgbPaginationModule } from '@ng-bootstrap/ng-bootstrap';
import { FormsModule } from '@angular/forms';
import { SearchFilterPipe } from './pipes/search-filter.pipe';
import { ConfirmDialogModule } from 'primeng/confirmdialog';
import { ToastModule } from 'primeng/toast';
import { RouterModule } from '@angular/router';

import { AvatarModule } from 'primeng/avatar';
import { UserProfileComponent } from './pages/user-profile/user-profile.component';
import { ProfileComponent } from './components/profile/profile.component';
import { DialogModule } from 'primeng/dialog';
import { InputMaskModule } from 'primeng/inputmask';
import { SharedModule } from '../shared/shared.module';
import { TooltipModule } from 'primeng/tooltip';

@NgModule({
  declarations: [
    ClientComponent,
    TableClientsComponent,
    SearchFilterPipe,
    UserProfileComponent,
    ProfileComponent,
  ],
  imports: [
    CommonModule,
    ClientRoutingModule,
    NgbPaginationModule,
    FormsModule,
    ConfirmDialogModule,
    ToastModule,
    RouterModule,
    AvatarModule,
    RouterModule,
    DialogModule,
    InputMaskModule,
    SharedModule,
    TooltipModule,
  ],
})
export class ClientModule {}
