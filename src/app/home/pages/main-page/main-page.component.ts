import { Component, OnInit, Output } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-main-page',
  templateUrl: './main-page.component.html',
  styleUrls: ['./main-page.component.css'],
})
export class MainPageComponent implements OnInit {
  incorrectLogin: boolean = false;

  constructor(private authService: AuthService, private router: Router) {}

  ngOnInit(): void {}

  login(user: { username: ''; password: '' }) {
    this.authService.loginUser(user).subscribe({
      next: () => {
        this.router.navigate(['client']);
      },
      error: () => (this.incorrectLogin = true),
    });
  }
}
