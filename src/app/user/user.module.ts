import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { UserRoutingModule } from './user-routing.module';
import { UserComponent } from './Pages/page-users/user.component';
import { SharedModule } from '../shared/shared.module';
import { TableAdminUsersComponent } from './Components/table-admin/table-admin-users.component';
import { NgbPaginationModule } from '@ng-bootstrap/ng-bootstrap';
import { FormsModule } from '@angular/forms';
import { ConfirmDialogModule } from 'primeng/confirmdialog';
import { DialogModule } from 'primeng/dialog';
import { ToastModule } from 'primeng/toast';
import { InputSwitchModule } from 'primeng/inputswitch';
import { SearchFilterUsersPipe } from './Pipes/search-filter-users.pipe';
import { IsAdminPipe } from './pipes/is-admin.pipe';

@NgModule({
  declarations: [
    UserComponent,
    TableAdminUsersComponent,
    SearchFilterUsersPipe,
    IsAdminPipe,
  ],
  imports: [
    CommonModule,
    UserRoutingModule,
    SharedModule,
    NgbPaginationModule,
    FormsModule,
    ConfirmDialogModule,
    DialogModule,
    ToastModule,
    InputSwitchModule,
  ],
})
export class UserModule {}
