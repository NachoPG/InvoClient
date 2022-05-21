import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Clients } from '../../interfaces/clients.interface';
import { ClientService } from '../../services/client.service';

@Component({
  selector: 'app-client',
  templateUrl: './client.component.html',
  styleUrls: ['./client.component.css'],
})
export class ClientComponent implements OnInit {
  clientsList: Clients[] = [];
  errorDelete: boolean = false;
  errorUpdate: boolean = false;
  errorCreate: boolean = false;
  errorTextUpdate: string = '';
  errorTextCreate: string = '';
  constructor(private clientService: ClientService, private router: Router) {}

  ngOnInit(): void {
    this.getAllClients();
  }

  getAllClients() {
    this.clientService.getClients().subscribe({
      next: (response) => (this.clientsList = response),
      error: (err) => console.log(err),
    });
  }

  deleteClient(id: string) {
    this.clientService.deleteClient(id).subscribe({
      next: () => {
        this.ngOnInit();
      },
      error: (err) => {
        console.log(err);
        this.errorDelete = true;
      },
    });
  }

  editClient(client: Clients) {
    this.clientService.updateClient(client).subscribe({
      next: () => {
        this.errorUpdate = false;
        this.ngOnInit();
      },
      error: (err) => {
        console.log(err);
        this.errorUpdate = true;
        this.errorTextUpdate = err.error.message;
      },
    });
  }

  addClient(client: Clients) {
    this.clientService.addClient(client).subscribe({
      next: () => {
        this.errorCreate = false;
        this.ngOnInit();
      },
      error: (err) => {
        this.errorCreate = true;
        console.log(err);
        this.errorTextCreate = err.error.message;
      },
    });
  }

  showInvoicesFromClient(idClient: string) {
    this.router.navigate(['/invoice', idClient]);
  }
}
