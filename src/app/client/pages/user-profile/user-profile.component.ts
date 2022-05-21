import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { PasswordChange } from '../../interfaces/passwordChange.interface';
import { UserService } from '../../services/user.service';

@Component({
  selector: 'app-user-profile',
  templateUrl: './user-profile.component.html',
  styleUrls: ['./user-profile.component.css'],
})
export class UserProfileComponent implements OnInit {
  errorResponsePassword: boolean = false;

  constructor(private userService: UserService, private router: Router) {}

  ngOnInit(): void {}

  changePassword(dataPassword: PasswordChange) {
    this.userService.changePassword(dataPassword).subscribe({
      next: () => {
        this.errorResponsePassword = false;
        localStorage.clear();
        setTimeout(() => {
          this.router.navigate(['/']);
        }, 500);
      },
      error: (err) => {
        console.log(err);
        this.errorResponsePassword = true;
      },
    });
  }
}
