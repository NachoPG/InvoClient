import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
})
export class LoginComponent implements OnInit {
  userCredentials: { username: ''; password: '' } = {
    username: '',
    password: '',
  };
  @Output() onSubmit: EventEmitter<{ username: ''; password: '' }> =
    new EventEmitter();
  validatorLogin: boolean = false;
  @Input() incorrectLogin: boolean = false;

  constructor() {}

  ngOnInit(): void {}

  login() {
    if (
      this.userCredentials.username !== '' &&
      this.userCredentials.password !== ''
    ) {
      this.onSubmit.emit(this.userCredentials);
      this.validatorLogin = false;
    } else {
      this.validatorLogin = true;
    }
  }
}
