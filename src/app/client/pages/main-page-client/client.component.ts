import { Component, OnInit } from '@angular/core';
import { Clients } from '../../interfaces/clients.interface';
import { ClientService } from '../../services/client.service';

@Component({
  selector: 'app-client',
  templateUrl: './client.component.html',
  styleUrls: ['./client.component.css'],
})
export class ClientComponent implements OnInit {
  clientsList: Clients[] = [];

  constructor(private clientService: ClientService) {}

  ngOnInit(): void {
    this.getAllClients();
  }

  getAllClients() {
    this.clientService.getClients().subscribe({
      next: (response) => (this.clientsList = response),
      error: (err) => console.log(err),
    });
  }
}
