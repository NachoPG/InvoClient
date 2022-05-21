import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { PasswordChange } from '../../interfaces/passwordChange.interface';
import { MessageService } from 'primeng/api';
import { Router } from '@angular/router';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css'],
  providers: [MessageService],
})
export class ProfileComponent implements OnInit {
  name!: string;
  surname!: string;
  username!: string;
  isAdmin: boolean | null =
    localStorage.getItem('admin') === '1' ? true : false;

  dataPassword: PasswordChange = {
    idUser: '',
    oldPassword: '',
    newPassword: '',
    username: '',
  };

  @Input() showErrorPassword: boolean = false;

  @Output() onSubmitPassword: EventEmitter<PasswordChange> = new EventEmitter();

  constructor(private messageService: MessageService, private router: Router) {}

  ngOnInit(): void {
    this.setDataUser();
  }

  navigateToAdmin() {
    this.router.navigate(['/admin-panel']);
  }

  private setDataUser() {
    const user = JSON.parse(localStorage.getItem('user')!);
    const { idUser, firstname, lastname, username } = user;
    this.name = firstname;
    this.surname = lastname;
    this.username = username;
    this.dataPassword.username = username;
    this.dataPassword.idUser = idUser;
  }

  changePassword() {
    const { oldPassword, newPassword } = this.dataPassword;
    if (oldPassword !== '' && newPassword !== '') {
      this.onSubmitPassword.emit(this.dataPassword);

      setTimeout(() => {
        // console.log(this.showErrorPassword);
        if (!this.showErrorPassword) {
          this.messageService.add({
            severity: 'success',
            summary: 'Password Cambiada',
            detail: 'Se ha cambiado la password con exito',
          });
        } else {
          this.messageService.add({
            severity: 'error',
            summary: 'Error',
            detail:
              'Se ha producido un error. Compruebe la password introducida',
          });
        }
      }, 500);
    }
  }
}
