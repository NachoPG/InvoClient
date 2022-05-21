import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { ConfirmationService, MessageService } from 'primeng/api';
import { User } from '../../Intefaces/user.interface';
import { UserData } from '../../Intefaces/userData.interface';

@Component({
  selector: 'app-table-admin-users',
  templateUrl: './table-admin-users.component.html',
  styleUrls: ['./table-admin-users.component.css'],
  providers: [ConfirmationService, MessageService],
})
export class TableAdminUsersComponent implements OnInit {
  @Output() onClickDelete: EventEmitter<string> = new EventEmitter();
  @Output() onSubmitCreateUser: EventEmitter<User> = new EventEmitter();
  @Input() listUsers: UserData[] = [];
  @Input() showErrorDelete: boolean = false;
  @Input() showErrorCreate: boolean = false;

  userCreateActive: User = {
    name: '',
    surname: '',
    admin: false,
  };
  page: number = 1;
  pageSize: number = 10;
  searchValue: string = '';
  display: boolean = false;
  checked: boolean = false;

  constructor(
    private confirmationService: ConfirmationService,
    private messageService: MessageService
  ) {}

  ngOnInit(): void {}

  resetSearch() {
    this.searchValue = '';
  }

  hideDialog() {
    this.display = false;
  }

  showDialogCreate() {
    this.display = true;
    this.userCreateActive = {} as User;
  }

  saveUser() {
    const { name, surname, admin } = this.userCreateActive;
    if (
      name !== '' &&
      name !== undefined &&
      surname !== '' &&
      surname !== undefined
    ) {
      this.userCreateActive.admin = this.checked;
      this.onSubmitCreateUser.emit(this.userCreateActive);

      setTimeout(() => {
        if (!this.showErrorCreate) {
          this.messageService.add({
            severity: 'success',
            summary: 'Creado con Exito',
            detail: 'Se ha creado con Exito!',
          });
          this.hideDialog();
        } else {
          this.messageService.add({
            severity: 'error',
            summary: 'Error',
            detail:
              'Se ha producido un error con la creacion del usuario. Compruebe los datos introducidos',
          });
        }
      }, 500);
    }
  }

  confirmDelete(id: string) {
    this.confirmationService.confirm({
      message: 'Do you want to delete this User?',
      header: 'Delete Confirmation',
      icon: 'pi pi-info-circle',
      accept: () => {
        this.onClickDelete.emit(id);

        setTimeout(() => {
          if (!this.showErrorDelete) {
            this.messageService.add({
              severity: 'success',
              summary: 'success',
              detail: 'Se ha eliminado correctamente',
            });
          } else {
            this.messageService.add({
              severity: 'error',
              summary: 'Error',
              detail: 'Se ha producido un error',
            });
          }
        }, 500);
      },
    });
  }
}
